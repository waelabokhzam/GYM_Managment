<?php

namespace App\Services\Game;

use App\Models\Game;
use App\Models\User;
use App\Notifications\GameNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class DeleteGameService
{
    public function delete(Game $game)
    {
        $game->delete();
        $users = User::where('id', '!=', Auth::id())->get();
        Notification::send($users, new GameNotification($game, "Delete", Auth::user()));
        return $game;
    }
}