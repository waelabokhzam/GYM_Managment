<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nutrition_program_id',
        'name',
        'description',
        'notes',
    ];

    public function nutritionProgram(): BelongsTo
    {
        return $this->belongsTo(NutritionProgram::class);
    }
}
