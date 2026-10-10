<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Models\Attendance;
use App\Models\Game;
use App\Models\TimeSlot;
use App\Models\User;
use App\Services\Attendance\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use InvalidArgumentException;

class AttendanceController extends Controller
{
    public function __construct(
        private readonly AttendanceService $service
    ) {}

    public function index(Request $request)
    {
        Gate::authorize('viewAny', Attendance::class);

        $filters = $request->only([
            'search',
            'person_type',
            'status',
            'date_from',
            'date_to',
            'time_slot_id',
            'game_id',
        ]);

        /*
        |--------------------------------------------------------------------------
        | اللاعب يرى حضوره فقط
        |--------------------------------------------------------------------------
        */

        if ($request->user()->hasRole('player')) {
            $filters['user_id'] = $request->user()->id;
        }

        $attendances = $this->service->getAttendances($filters);

        $timeSlots = TimeSlot::query()
            ->orderBy('start_time')
            ->get();

        $games = Game::query()
            ->orderBy('name')
            ->get();

        return view('attendances.index', compact(
            'attendances',
            'timeSlots',
            'games'
        ));
    }

    public function create()
    {
        Gate::authorize('create', Attendance::class);

        $users = User::query()
            ->whereHas('roles', function ($query) {
                $query->whereIn('name', [
                    'player',
                    'trainer',
                    'reception',
                ]);
            })
            ->orderBy('fullname')
            ->get();

        $timeSlots = TimeSlot::query()
            ->orderBy('start_time')
            ->get();

        $games = Game::query()
            ->orderBy('name')
            ->get();

        return view('attendances.create', compact(
            'users',
            'timeSlots',
            'games'
        ));
    }

    public function store(StoreAttendanceRequest $request)
    {
        Gate::authorize('create', Attendance::class);

        try {

            $this->service->createManual(
                $request->validated()
            );

        } catch (InvalidArgumentException $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('attendances.index')
            ->with('success', 'تم تسجيل الحضور بنجاح.');
    }

    public function show(Attendance $attendance)
    {
        Gate::authorize('view', $attendance);

        $attendance->load([
            'user',
            'timeSlot',
            'game',
        ]);

        return view('attendances.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        Gate::authorize('update', $attendance);

        $users = User::query()
            ->whereHas('roles', function ($query) {
                $query->whereIn('name', [
                    'player',
                    'trainer',
                    'reception',
                ]);
            })
            ->orderBy('fullname')
            ->get();

        $timeSlots = TimeSlot::query()
            ->orderBy('start_time')
            ->get();

        $games = Game::query()
            ->orderBy('name')
            ->get();

        return view('attendances.edit', compact(
            'attendance',
            'users',
            'timeSlots',
            'games'
        ));
    }

    public function update(
        UpdateAttendanceRequest $request,
        Attendance $attendance
    ) {
        Gate::authorize('update', $attendance);

        $attendance->update(
            $request->validated()
        );

        return redirect()
            ->route('attendances.index')
            ->with('success', 'تم تحديث سجل الحضور.');
    }

    public function destroy(Attendance $attendance)
    {
        Gate::authorize('delete', $attendance);

        $attendance->delete();

        return redirect()
            ->route('attendances.index')
            ->with('success', 'تم حذف سجل الحضور.');
    }

    public function checkout(Attendance $attendance)
    {
        Gate::authorize('checkout', $attendance);

        try {

            $this->service->checkout($attendance);

        } catch (InvalidArgumentException $e) {

            return back()
                ->with('error', $e->getMessage());
        }

        return back()
            ->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}