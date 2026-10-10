<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NutritionProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'coach_id',
        'notes',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'coach_id');
    }

    public function meals(): HasMany
    {
        return $this->hasMany(Meal::class);
    }
}
