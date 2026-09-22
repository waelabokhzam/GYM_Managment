<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('unique_number')
                ->unique();

            $table->decimal('height', 5, 2)
                ->nullable();

            $table->decimal('weight', 5, 2)
                ->nullable();

            $table->text('health_status')
                ->nullable();

            $table->string('occupation')
                ->nullable();
            $table->enum('gender', [
    'male',
    'female',
]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};