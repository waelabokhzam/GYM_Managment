<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\User;

class GamePolicy
{
    /**
     * عرض قائمة الألعاب.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            'admin',
            'reception',
            'trainer',
        ]);
    }

    /**
     * عرض لعبة.
     */
    public function view(User $user, Game $game): bool
    {
        return $user->hasAnyRole([
            'admin',
            'reception',
            'trainer',
        ]);
    }

    /**
     * إنشاء لعبة.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole([
            'admin',
            'reception',
        ]);
    }

    /**
     * تعديل لعبة.
     */
    public function update(User $user, Game $game): bool
    {
        return $user->hasAnyRole([
            'admin',
            'reception',
        ]);
    }

    /**
     * حذف لعبة.
     */
    public function delete(User $user, Game $game): bool
    {
        return $user->hasRole('admin');
    }
}
