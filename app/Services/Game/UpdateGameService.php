<?php

namespace App\Services\Game;

use App\Models\Game;
use App\Models\User;
use App\Notifications\GameNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class UpdateGameService
{
    public function update(array $data, Game $game)
    {
        $game->update($data);
        $users = User::where('id', '!=', Auth::id())->get();
        Notification::send($users, new GameNotification($game, "Update", Auth::user()));
        return $game;

    }
}