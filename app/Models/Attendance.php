<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'person_type',
        'check_in',
        'check_out',
        'checkout_type',
        'status',
        'time_slot_id',
        'game_id',
        'device',
        'fingerprint_id',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'check_in' => 'datetime',
            'check_out' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function getDurationInMinutesAttribute(): ?int
    {
        if (!$this->check_in || !$this->check_out) {
            return null;
        }

        return $this->check_in->diffInMinutes($this->check_out);
    }

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function isCompleted(): bool
    {
        return in_array($this->status, [
            'completed',
            'auto_closed',
        ]);
    }
}
