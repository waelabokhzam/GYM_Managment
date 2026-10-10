<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('nutrition_program_id')
                ->constrained('nutrition_programs')
                ->cascadeOnDelete();

            $table->string('name'); // مثلاً: "الفطور"
            $table->text('description'); // مثلاً: "بيض + خبز + خضار"
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
