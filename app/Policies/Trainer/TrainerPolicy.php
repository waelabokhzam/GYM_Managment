<?php

namespace App\Policies\Trainer;

use App\Models\Staff;
use App\Models\User;

class TrainerPolicy
{
    /*
    |--------------------------------------------------------------------------
    | View Any
    |--------------------------------------------------------------------------
    */

    public function viewAny(User $user): bool
    {
        return $user->can('trainers.view');
    }


    /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    */

    public function view(User $user, Staff $trainer): bool
    {
        return
            $trainer->role === 'trainer'
            && $user->can('trainers.view');
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create(User $user): bool
    {
        return $user->can('trainers.create');
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(User $user, Staff $trainer): bool
    {
        return
            $trainer->role === 'trainer'
            && $user->can('trainers.edit');
    }


    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function delete(User $user, Staff $trainer): bool
    {
        return
            $trainer->role === 'trainer'
            && $user->can('trainers.delete');
    }
}