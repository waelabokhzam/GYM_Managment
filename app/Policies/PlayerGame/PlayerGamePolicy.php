<?php

namespace App\Policies\PlayerGame;

use App\Models\PlayerGame;
use App\Models\User;

class PlayerGamePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('players.view');
    }

    public function view(User $user): bool
    {
        return $user->can('players.view');
    }

    public function create(User $user): bool
    {
        return $user->can('players.edit');
    }

    public function update(User $user): bool
    {
        return $user->can('players.edit');
    }

    public function delete(User $user): bool
    {
        return $user->can('players.edit');
    }
}