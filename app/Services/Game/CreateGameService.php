<?php

namespace App\Services\Game;

use App\Models\Game;
use App\Models\User;
use App\Notifications\GameNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CreateGameService
{
    public function create(array $data)
    {
        $timeSlotIds = $data['time_slots'] ?? [];

        unset($data['time_slots']);

        $game = DB::transaction(function () use ($data, $timeSlotIds) {

            $game = Game::create($data);

            $game->timeSlots()->sync($timeSlotIds);

            return $game;
        });

        $users = User::where('id', '!=', Auth::id())->get();

        Notification::send(
            $users,
            new GameNotification(
                $game,
                'Create',
                Auth::user()
            )
        );

        return $game;
    }
}
