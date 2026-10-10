<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'private_trainer_id',
        'unique_number',
        'gender',
        'height',
        'weight',
        'health_status',
        'occupation',
    ];

    /**
     * اللاعب تابع لحساب User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }

    public function playerGames(): HasMany
    {
        return $this->hasMany(PlayerGame::class);
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(
            Game::class,
            'player_games',
            'player_id',
            'game_id'
        )->withTimestamps();
    }

    public function trainingPrograms(): HasMany
{
    return $this->hasMany(TrainingProgram::class);
}

public function nutritionPrograms(): HasMany
{
    return $this->hasMany(NutritionProgram::class);
}

}
