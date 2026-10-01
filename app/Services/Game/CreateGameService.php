<?php

namespace App\Services\Game;

use App\Models\Game;
use App\Models\User;
use App\Notifications\GameNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CreateGameService
{
    public function create(array $data)
    {
        $game = Game::create($data);

        $users = User::where('id', '!=', Auth::id())->get();

        Notification::send($users, new GameNotification($game, "Create", Auth::user()));

        return $game;
    }
}