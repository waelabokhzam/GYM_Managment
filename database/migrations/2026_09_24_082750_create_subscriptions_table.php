<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('player_id')
                ->constrained('players')
                ->cascadeOnDelete();

            $table->enum('sub_type', [
                'special',
                'offers',
                'daily',
                'monthly'
            ]);

            $table->enum('registration_type', [
                'new',
                'renew'
            ]);

            $table->date('start_date');
            $table->date('end_date');

            $table->enum('status', [
                'active',
                'expired'
            ])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};