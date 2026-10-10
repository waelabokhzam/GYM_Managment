<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_programs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('player_id')
                ->constrained('players')
                ->cascadeOnDelete();

            $table->foreignId('coach_id')
                ->constrained('staff')
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_programs');
    }
};
