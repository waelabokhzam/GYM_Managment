<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'user_id',
        'role',
        'salary_type',
        'base_salary',
    ];

    protected function casts(): array
    {
        return [
            'base_salary' => 'decimal:2',
        ];
    }

    /**
     * الحساب المرتبط بالموظف
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Trainer Time Slots
    |--------------------------------------------------------------------------
    */

    public function trainerTimeSlots(): HasMany
    {
        return $this->hasMany(
            TrainerTimeSlot::class,
            'staff_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Trainer Game Time Slots
    |--------------------------------------------------------------------------
    */

    public function trainerGameTimeSlots(): HasMany
    {
        return $this->hasMany(
            TrainerGameTimeSlot::class,
            'staff_id'
        );
    }
}