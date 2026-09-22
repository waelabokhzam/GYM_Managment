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
        'height',
        'weight',
        'health_status',
        'occupation',
    ];

    protected function casts(): array
    {
        return [
            'height' => 'decimal:2',
            'weight' => 'decimal:2',
        ];
    }

    /**
     * الحساب المرتبط باللاعب
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}