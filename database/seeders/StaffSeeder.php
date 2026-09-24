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
                'phone' => '0000000000',
                'password' => Hash::make('admin123'),
            ]
        );

        // Spatie Role
        $admin->syncRoles(['admin']);

        // Staff
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
                'phone' => '0000000001',
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
                'role' => 'reception',
                'salary_type' => 'fixed',
                'base_salary' => 0,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Success Message
        |--------------------------------------------------------------------------
        */

        $this->command->info(
            'Admin and Reception accounts created successfully.'
        );
    }
}
