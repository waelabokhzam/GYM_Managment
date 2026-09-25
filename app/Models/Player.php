<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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
    public function Receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}
