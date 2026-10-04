<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TimeSlot extends Model
{
    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'gender_type',
        'days',
    ];

    protected $casts = [
        'days' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Trainers
    |--------------------------------------------------------------------------
    */

    public function trainerTimeSlots(): HasMany
    {
        return $this->hasMany(
            TrainerTimeSlot::class
        );
    }

    public function trainers(): BelongsToMany
    {
        return $this->belongsToMany(
            Staff::class,
            'trainer_time_slots',
            'time_slot_id',
            'staff_id'
        )->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Games
    |--------------------------------------------------------------------------
    */

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(
            Game::class,
            'game_time_slot',
            'time_slot_id',
            'game_id'
        )->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Trainer + Game Assignments
    |--------------------------------------------------------------------------
    */

    public function trainerGameTimeSlots(): HasMany
    {
        return $this->hasMany(
            TrainerGameTimeSlot::class
        );
    }
}