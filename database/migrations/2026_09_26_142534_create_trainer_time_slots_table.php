<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainer_time_slots', function (Blueprint $table) {

            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnDelete();

            $table->foreignId('time_slot_id')
                ->constrained('time_slots')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'staff_id',
                'time_slot_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainer_time_slots');
    }
};