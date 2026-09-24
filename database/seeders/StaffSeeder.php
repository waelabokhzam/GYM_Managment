<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        $admin = User::updateOrCreate(
            [
                'username' => 'gym_admin',
            ],
            [
                'fullname' => 'مدير النظام',
                'password' => Hash::make('admin123'),
            ]
        );

        // تعيين Spatie Role
        $admin->syncRoles(['admin']);

        // إنشاء سجل الموظف
        Staff::updateOrCreate(
            [
                'user_id' => $admin->id,
            ],
            [
                'role' => 'admin',
                'salary_type' => 'fixed',
                'base_salary' => 0,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Reception
        |--------------------------------------------------------------------------
        */

        $reception = User::updateOrCreate(
            [
                'username' => 'gym_reception',
            ],
            [
                'fullname' => 'موظف الاستقبال',
                'password' => Hash::make('reception123'),
            ]
        );

        // Spatie Role
        $reception->syncRoles(['reception']);

        // Staff
        Staff::updateOrCreate(
            [
                'user_id' => $reception->id,
            ],
            [
                'role' => 'receptionist',
                'salary_type' => 'fixed',
                'base_salary' => 0,
            ]
        );

        $this->command->info('Admin and Reception accounts created successfully.');
    }
}
