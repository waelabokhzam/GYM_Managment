<?php

namespace App\Policies\TrainerTime;

use App\Models\TrainerTimeSlot;
use App\Models\User;

class TrainerTimeSlotPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('training_periods.view');
    }

    public function view(User $user): bool
    {
        return $user->can('training_periods.view');
    }

    public function create(User $user): bool
    {
        return $user->can('training_periods.create');
    }

    public function update(User $user): bool
    {
        return $user->can('training_periods.edit');
    }

    public function delete(User $user): bool
    {
        return $user->can('training_periods.delete');
    }
}