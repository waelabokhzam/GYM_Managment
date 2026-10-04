<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlayerActivityController extends Controller
{
    /**
     * جلب الألعاب المشترك بها اللاعب الحالي
     * مع جميع الفترات المتاحة لكل لعبة
     * والمدرب المسؤول عن اللعبة في كل فترة.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        // جلب Player الخاص بالمستخدم الحالي
        $player = Player::query()
            ->where('user_id', $user->id)
            ->first();

        if (!$player) {
            return response()->json([
                'success' => false,
                'message' => 'حساب اللاعب غير موجود.',
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | الألعاب المشترك بها اللاعب
        |--------------------------------------------------------------------------
        */

        $games = $player->games()
            ->with([
                'timeSlots' => function ($query) {
                    $query
                        ->orderBy('start_time')
                        ->with([
                            'trainerGameTimeSlots.trainer.user',
                        ]);
                },
            ])
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | تجهيز البيانات
        |--------------------------------------------------------------------------
        */

        $data = $games->map(function ($game) {

            return [
                'id' => $game->id,

                'name' => $game->name,

                'description' => $game->description,

                'time_slots' => $game->timeSlots
                    ->map(function ($timeSlot) use ($game) {

                        /*
                        |--------------------------------------------------------------------------
                        | إيجاد المدرب المسؤول عن هذه اللعبة
                        | في هذه الفترة تحديدًا
                        |--------------------------------------------------------------------------
                        */

                        $assignment = $timeSlot
                            ->trainerGameTimeSlots
                            ->firstWhere(
                                'game_id',
                                $game->id
                            );

                        $trainer = null;

                        if ($assignment?->trainer) {

                            $trainer = [
                                'id' => $assignment->trainer->id,

                                'name' => $assignment
                                    ->trainer
                                    ->user
                                    ?->fullname,

                                'username' => $assignment
                                    ->trainer
                                    ->user
                                    ?->username,
                            ];
                        }

                        return [
                            'id' => $timeSlot->id,

                            'name' => $timeSlot->name,

                            'start_time' => $timeSlot->start_time,

                            'end_time' => $timeSlot->end_time,

                            'gender_type' => $timeSlot->gender_type,

                            'days' => $timeSlot->days,

                            'trainer' => $trainer,
                        ];
                    })
                    ->values()
                    ->toArray(),
            ];
        })
        ->values()
        ->toArray();

        return response()->json([
            'success' => true,

            'message' => 'تم جلب الألعاب والفترات والمدربين بنجاح.',

            'data' => $data,
        ]);
    }
}


