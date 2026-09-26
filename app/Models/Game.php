<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        "name",
        "description"
    ];

    public function Receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}
