<?php

namespace App\Services\Attendance;

use App\Models\Attendance;
use App\Models\Game;
use App\Models\TimeSlot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class AttendanceService
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function getAttendances(array $filters = []): LengthAwarePaginator
    {
        return Attendance::query()
            ->with([
                'user',
                'timeSlot',
                'game',
            ])
            ->when(
                $filters['user_id'] ?? null,
                fn (Builder $query, int $userId) =>
                    $query->where('user_id', $userId)
            )
            ->when(
                $filters['search'] ?? null,
                function (Builder $query, string $search) {
                    $query->whereHas('user', function (Builder $userQuery) use ($search) {
                        $userQuery
                            ->where('fullname', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
                }
            )
            ->when(
                $filters['person_type'] ?? null,
                fn (Builder $query, string $type) =>
                    $query->where('person_type', $type)
            )
            ->when(
                $filters['status'] ?? null,
                fn (Builder $query, string $status) =>
                    $query->where('status', $status)
            )
            ->when(
                $filters['date_from'] ?? null,
                fn (Builder $query, string $date) =>
                    $query->whereDate('check_in', '>=', $date)
            )
            ->when(
                $filters['date_to'] ?? null,
                fn (Builder $query, string $date) =>
                    $query->whereDate('check_in', '<=', $date)
            )
            ->when(
                $filters['time_slot_id'] ?? null,
                fn (Builder $query, int $timeSlotId) =>
                    $query->where('time_slot_id', $timeSlotId)
            )
            ->when(
                $filters['game_id'] ?? null,
                fn (Builder $query, int $gameId) =>
                    $query->where('game_id', $gameId)
            )
            ->latest('check_in')
            ->paginate(15)
            ->withQueryString();
    }

    /*
    |--------------------------------------------------------------------------
    | Manual attendance
    |--------------------------------------------------------------------------
    */

    public function createManual(array $data): Attendance
    {
        return DB::transaction(function () use ($data) {

            $user = User::findOrFail($data['user_id']);

            $personType = $this->resolvePersonType($user);

            $checkIn = isset($data['check_in'])
                ? Carbon::parse($data['check_in'])
                : now();

            /*
            |--------------------------------------------------------------------------
            | منع وجود دخول مفتوح لنفس الشخص
            |--------------------------------------------------------------------------
            */

            $openAttendance = Attendance::query()
                ->where('user_id', $user->id)
                ->where('status', 'open')
                ->first();

            if ($openAttendance) {
                throw new InvalidArgumentException(
                    'يوجد دخول مفتوح لهذا الشخص بالفعل.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | التحقق من الفترة للاعب والمدرب
            |--------------------------------------------------------------------------
            */

            if (
                in_array($personType, ['player', 'trainer'])
                && empty($data['time_slot_id'])
            ) {
                throw new InvalidArgumentException(
                    'يجب تحديد الفترة للاعب أو المدرب.'
                );
            }

            return Attendance::create([
                'user_id' => $user->id,
                'person_type' => $personType,
                'check_in' => $checkIn,
                'time_slot_id' => $data['time_slot_id'] ?? null,
                'game_id' => $data['game_id'] ?? null,
                'device' => $data['device'] ?? 'manual',
                'fingerprint_id' => $data['fingerprint_id'] ?? null,
                'notes' => $data['notes'] ?? null,
                'status' => 'open',
            ]);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Fingerprint
    |--------------------------------------------------------------------------
    |
    | هذه أهم دالة.
    |
    */

    public function processFingerprint(
        User $user,
        ?string $fingerprintId = null,
        ?string $device = 'ZKTeco ZK4500'
    ): Attendance {
        return DB::transaction(function () use (
            $user,
            $fingerprintId,
            $device
        ) {

            $personType = $this->resolvePersonType($user);

            /*
            |--------------------------------------------------------------------------
            | Reception
            |--------------------------------------------------------------------------
            |
            | البصمة الأولى = دخول
            | البصمة الثانية = خروج
            |
            */

            if ($personType === 'reception') {

                $openAttendance = Attendance::query()
                    ->where('user_id', $user->id)
                    ->where('person_type', 'reception')
                    ->where('status', 'open')
                    ->latest('check_in')
                    ->first();

                if ($openAttendance) {

                    $openAttendance->update([
                        'check_out' => now(),
                        'checkout_type' => 'manual',
                        'status' => 'completed',
                    ]);

                    return $openAttendance->fresh();
                }

                return Attendance::create([
                    'user_id' => $user->id,
                    'person_type' => 'reception',
                    'check_in' => now(),
                    'device' => $device,
                    'fingerprint_id' => $fingerprintId,
                    'status' => 'open',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Player / Trainer
            |--------------------------------------------------------------------------
            |
            | البصمة دائماً دخول.
            |
            */

            $openAttendance = Attendance::query()
                ->where('user_id', $user->id)
                ->whereIn('person_type', ['player', 'trainer'])
                ->where('status', 'open')
                ->latest('check_in')
                ->first();

            if ($openAttendance) {
                throw new InvalidArgumentException(
                    'هذا الشخص لديه حضور مفتوح حالياً.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | إيجاد الفترة الحالية
            |--------------------------------------------------------------------------
            */

            $timeSlot = $this->resolveCurrentTimeSlot();

            if (!$timeSlot) {
                throw new InvalidArgumentException(
                    'لا توجد فترة تدريب حالية مرتبطة بهذا الوقت.'
                );
            }

            return Attendance::create([
                'user_id' => $user->id,
                'person_type' => $personType,
                'check_in' => now(),
                'time_slot_id' => $timeSlot->id,
                'device' => $device,
                'fingerprint_id' => $fingerprintId,
                'status' => 'open',
            ]);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Manual checkout
    |--------------------------------------------------------------------------
    */

    public function checkout(Attendance $attendance): Attendance
    {
        if ($attendance->status !== 'open') {
            throw new InvalidArgumentException(
                'هذا الحضور مغلق مسبقاً.'
            );
        }

        $attendance->update([
            'check_out' => now(),
            'checkout_type' => 'manual',
            'status' => 'completed',
        ]);

        return $attendance->fresh();
    }

    /*
    |--------------------------------------------------------------------------
    | Automatic checkout
    |--------------------------------------------------------------------------
    |
    | سيتم تشغيلها لاحقاً بواسطة Scheduler.
    |
    */

    public function autoCloseExpiredAttendances(): int
    {
        $now = now();

        $attendances = Attendance::query()
            ->where('status', 'open')
            ->whereIn('person_type', ['player', 'trainer'])
            ->whereNotNull('time_slot_id')
            ->with('timeSlot')
            ->get();

        $closed = 0;

        foreach ($attendances as $attendance) {

            if (!$attendance->timeSlot) {
                continue;
            }

            $endTime = Carbon::parse(
                $now->format('Y-m-d') . ' ' .
                $attendance->timeSlot->end_time
            );

            if ($now->greaterThanOrEqualTo($endTime)) {

                $attendance->update([
                    'check_out' => $endTime,
                    'checkout_type' => 'automatic',
                    'status' => 'auto_closed',
                ]);

                $closed++;
            }
        }

        return $closed;
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function resolvePersonType(User $user): string
    {
        if ($user->hasRole('player')) {
            return 'player';
        }

        if ($user->hasRole('trainer')) {
            return 'trainer';
        }

        if ($user->hasRole('reception')) {
            return 'reception';
        }

        throw new InvalidArgumentException(
            'هذا المستخدم لا يملك نوع مستخدم صالح للحضور.'
        );
    }

    private function resolveCurrentTimeSlot(): ?TimeSlot
    {
        $now = now();

        $day = strtolower(
            $now->format('D')
        );

        $dayMap = [
            'sat' => 'saturday',
            'sun' => 'sunday',
            'mon' => 'monday',
            'tue' => 'tuesday',
            'wed' => 'wednesday',
            'thu' => 'thursday',
            'fri' => 'friday',
        ];

        $currentDay = $dayMap[$day] ?? null;

        if (!$currentDay) {
            return null;
        }

        return TimeSlot::query()
            ->whereTime(
                'start_time',
                '<=',
                $now->format('H:i:s')
            )
            ->whereTime(
                'end_time',
                '>=',
                $now->format('H:i:s')
            )
            ->whereJsonContains(
                'days',
                $currentDay
            )
            ->orderBy('start_time')
            ->first();
    }
}