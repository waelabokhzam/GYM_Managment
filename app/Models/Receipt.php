<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Receipt extends Model
{
    protected $fillable = [
        'game_id',
        'subscription_id',
        'player_id',
        'received_by',
        'amount',
        'payment_date',
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Receipt $receipt) {
            $receipt->receipt_number ??= (string) Str::uuid();
        });
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function receivedBy()
    {
        return $this->belongsTo(Staff::class);
    }
    // public function subscription()
    // {
    //     return $this->belongsTo(Subscription::class);
    // }
}
