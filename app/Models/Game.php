<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Game extends Model
{
    protected $fillable = [
        "name",
        "description",
        "type",
        "image",
    ];

    protected function image(): Attribute
{
    return Attribute::make(
        get: fn ($value) => $value ? asset('storage/' . $value) : null,
    );
}

    public function Receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    public function playerGames(): HasMany
    {
        return $this->hasMany(PlayerGame::class);
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(
            Player::class,
            'player_games',
            'game_id',
            'player_id'
        )->withTimestamps();
    }
     public function timeSlots(): BelongsToMany
    {
        return $this->belongsToMany(
            TimeSlot::class,
            'game_time_slot',
            'game_id',
            'time_slot_id'
        )->withTimestamps();
    }
    public function trainerGameTimeSlots(): HasMany
    {
        return $this->hasMany(
            TrainerGameTimeSlot::class
        );
    }

}
