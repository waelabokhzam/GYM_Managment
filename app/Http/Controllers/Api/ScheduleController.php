<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function day(Request $request, string $day): JsonResponse
    {
        $timeSlots = TimeSlot::query()
            ->whereJsonContains('days', $day)
            ->with([
                'games',
                'trainerGameTimeSlots.trainer.user',
                'trainerGameTimeSlots.game',
            ])
            ->orderBy('start_time')
            ->get();

        $data = $timeSlots->map(function (TimeSlot $timeSlot) {

            $games = $timeSlot->games
                ->map(function ($game) use ($timeSlot) {

                    $assignment = $timeSlot
                        ->trainerGameTimeSlots
                        ->firstWhere(
                            'game_id',
                            $game->id
                        );

                    return [
                        'id' => $game->id,
                        'name' => $game->name,
                        'description' => $game->description,

                        'trainer' => $assignment
                            ? [
                                'id' => $assignment->trainer->id,

                                'name' => $assignment
                                    ->trainer
                                    ->user
                                    ->fullname,

                                'username' => $assignment
                                    ->trainer
                                    ->user
                                    ->username,
                            ]
                            : null,
                    ];
                })
                ->values();

            return [
                'id' => $timeSlot->id,
                'name' => $timeSlot->name,
                'start_time' => $timeSlot->start_time,
                'end_time' => $timeSlot->end_time,
                'gender_type' => $timeSlot->gender_type,
                'days' => $timeSlot->days,
                'games' => $games,
            ];
        })->values();

        return response()->json([
            'success' => true,
            'day' => $day,
            'data' => $data,
        ]);
    }
}