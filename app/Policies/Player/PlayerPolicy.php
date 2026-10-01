<?php

namespace App\Policies\Player;

use App\Models\Player;
use App\Models\User;

class PlayerPolicy
{
    /**
     * هل يستطيع المستخدم مشاهدة قائمة اللاعبين؟
     */
    public function viewAny(User $user): bool
    {
        return $user->can('players.view');
    }

    /**
     * هل يستطيع المستخدم مشاهدة لاعب معين؟
     */
    public function view(User $user, Player $player): bool
    {
        // الإدارة والموظفون الذين يملكون players.view
        if ($user->can('players.view')) {
            return true;
        }

        // اللاعب يستطيع مشاهدة بياناته فقط
        return $player->user_id === $user->id;
    }

    /**
     * هل يستطيع المستخدم إنشاء لاعب؟
     */
    public function create(User $user): bool
    {
        return $user->can('players.create');
    }

    /**
     * هل يستطيع المستخدم تعديل لاعب؟
     */
    public function update(User $user, Player $player): bool
    {
        return $user->can('players.edit');
    }

    /**
     * هل يستطيع المستخدم حذف لاعب؟
     */
    public function delete(User $user, Player $player): bool
    {
        return $user->can('players.delete');
    }

    /**
     * هل يستطيع المستخدم استعادة لاعب؟
     */
    public function restore(User $user, Player $player): bool
    {
        return $user->can('players.edit');
    }

    /**
     * هل يستطيع المستخدم حذف اللاعب نهائياً؟
     */
    public function forceDelete(User $user, Player $player): bool
    {
        return $user->can('players.delete');
    }
}