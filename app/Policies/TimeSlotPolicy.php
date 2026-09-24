<?php

namespace App\Policies;

use App\Models\TimeSlot;
use App\Models\User;

class TimeSlotPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('timeslots.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TimeSlot $timeSlot): bool
    {
        return $user->can('timeslots.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('timeslots.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TimeSlot $timeSlot): bool
    {
        return $user->can('timeslots.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TimeSlot $timeSlot): bool
    {
        return $user->can('timeslots.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TimeSlot $timeSlot): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TimeSlot $timeSlot): bool
    {
        return false;
    }
}
