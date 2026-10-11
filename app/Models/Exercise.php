<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_day_id',
        'name',
        'sets',
        'reps',
        'notes',
    ];

    public function trainingDay(): BelongsTo
    {
        return $this->belongsTo(TrainingDay::class);
    }
}
