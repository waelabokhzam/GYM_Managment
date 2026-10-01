<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_games', function (Blueprint $table) {

            $table->id();

            $table->foreignId('player_id')
                ->constrained('players')
                ->cascadeOnDelete();

            $table->foreignId('game_id')
                ->constrained('games')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'player_id',
                'game_id',
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_games');
    }
};