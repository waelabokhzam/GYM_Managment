<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_transactions', function (Blueprint $table) {

            $table->id();

            $table->enum('transaction_type', [
                'income',
                'expense',
            ]);

            $table->decimal('amount', 12, 2);

            $table->text('description');

            /*
            |--------------------------------------------------------------------------
            | الموظف الذي وافق / نفذ العملية
            |--------------------------------------------------------------------------
            */

            $table->foreignId('approved_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('transaction_type');
            $table->index('approved_by');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};