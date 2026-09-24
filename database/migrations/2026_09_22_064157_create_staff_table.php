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
        Schema::create('staff', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Staff Role
            |--------------------------------------------------------------------------
            |
            | admin      = مدير النظام
            | reception  = موظف استقبال
            | trainer    = مدرب
            |
            */

            $table->enum('role', [
                'admin',
                'reception',
                'trainer',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Salary
            |--------------------------------------------------------------------------
            |
            | fixed      = راتب ثابت
            | percentage = نسبة حسب عدد اللاعبين
            |
            */

            $table->enum('salary_type', [
                'fixed',
                'percentage',
            ]);

            /*
            | الراتب الأساسي
            |
            | إذا كان salary_type = fixed
            | يستخدم كراتب شهري.
            |
            | وإذا كان percentage
            | يمكن استخدامه حسب تصميم حساب النسبة.
            |
            */

            $table->decimal('base_salary', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
