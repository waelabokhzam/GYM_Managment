<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainerTimeSlot extends Model
{
    protected $fillable = [
        'staff_id',
        'time_slot_id',
    ];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(
            Staff::class,
            'staff_id'
        );
    }

    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(
            TimeSlot::class
        );
    }
}