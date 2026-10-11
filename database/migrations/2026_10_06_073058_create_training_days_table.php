<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_days', function (Blueprint $table) {
            $table->id();

            $table->foreignId('training_program_id')
                ->constrained('training_programs')
                ->cascadeOnDelete();

            $table->string('title'); // مثلاً: "Day 1 - صدر"
            $table->unsignedInteger('order')->default(0); // ترتيب اليوم ضمن البرنامج

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_days');
    }
};
