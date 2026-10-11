<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = [
        'player_id',
        'trainer_id',
        'sub_type',
        'registration_type',
        'start_date',
        'end_date',
        'status',
        'amount',
        'expiry_notification_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'amount' => 'decimal:2',
            'expiry_notification_sent_at' => 'datetime',
        ];
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'trainer_id'); // ⬅️ تصحيح: Staff::class
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}
