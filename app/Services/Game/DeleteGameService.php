<?php

namespace App\Services\Game;

use App\Models\Game;
use App\Models\User;
use App\Notifications\GameNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class DeleteGameService
{
    public function delete(Game $game)
    {
        DB::transaction(function () use ($game) {

            $game->timeSlots()->detach();

            $game->delete();
        });

        $users = User::where('id', '!=', Auth::id())->get();

        Notification::send(
            $users,
            new GameNotification(
                $game,
                'Delete',
                Auth::user()
            )
        );

        return $game;
    }
}
