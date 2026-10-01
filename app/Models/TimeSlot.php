<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TimeSlot extends Model
{
    protected $fillable = [
        'start_time',
        'end_time',
        'gender_type',
    ];

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
}
