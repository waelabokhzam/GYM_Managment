<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Clear Permission Cache
        |--------------------------------------------------------------------------
        */

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [

            // Players
            'players.view',
            'players.create',
            'players.edit',
            'players.delete',

            // Staff
            'staff.view',
            'staff.create',
            'staff.edit',
            'staff.delete',

            // Subscriptions
            'subscriptions.view',
            'subscriptions.create',
            'subscriptions.edit',
            'subscriptions.delete',

            //الفترات 
            'timeslots.create',
            'timeslots.edit',
            'timeslots.delete',
            'timeslots.view',

            // Training Periods
            'training_periods.view',
            'training_periods.create',
            'training_periods.edit',
            'training_periods.delete',

            // Sports
            'sports.view',
            'sports.create',
            'sports.edit',
            'sports.delete',

            // Payments
            'payments.view',
            'payments.create',
            'payments.edit',
            'payments.delete',

            // Attendance
            'attendance.view',
            'attendance.create',
            'attendance.edit',

            // Reports
            'reports.view',

            // Users
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // Roles & Permissions
            'roles.manage',
            'permissions.manage',
        ];

        /*
        |--------------------------------------------------------------------------
        | Create Permissions
        |--------------------------------------------------------------------------
        */

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $reception = Role::firstOrCreate([
            'name' => 'reception',
            'guard_name' => 'web',
        ]);

        $trainer = Role::firstOrCreate([
            'name' => 'trainer',
            'guard_name' => 'web',
        ]);

        $player = Role::firstOrCreate([
            'name' => 'player',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        |
        | Admin لديه جميع الصلاحيات في النظام.
        |
        */

        $admin->syncPermissions(
            Permission::where('guard_name', 'web')->get()
        );

        /*
        |--------------------------------------------------------------------------
        | Reception
        |--------------------------------------------------------------------------
        */

        $reception->syncPermissions([

            'timeslots.view',
            'timeslots.create',
            'timeslots.edit',
            'timeslots.delete',

            'subscriptions.view',
            'subscriptions.create',
            'subscriptions.edit',

            // Training Periods
            'training_periods.view',

            // Sports
            'sports.view',

            // Payments
            'payments.view',
            'payments.create',

            // Attendance
            'attendance.view',
            'attendance.create',

            // Reports
            'reports.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Trainer
        |--------------------------------------------------------------------------
        */

        $trainer->syncPermissions([

            // Players
            'players.view',

            // Staff
            'staff.view',

            // Subscriptions
            'subscriptions.view',

            'timeslots.view',

            'training_periods.view',

            // Sports
            'sports.view',

            // Attendance
            'attendance.view',
            'attendance.create',
            'attendance.edit',

            // Reports
            'reports.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Player
        |--------------------------------------------------------------------------
        */

        $player->syncPermissions([

            // Player
            'players.view',

            // Subscriptions
            'subscriptions.view',

            'timeslots.view',

            'training_periods.view',

            // Sports
            'sports.view',

            // Attendance
            'attendance.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Clear Permission Cache
        |--------------------------------------------------------------------------
        */

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Success Message
        |--------------------------------------------------------------------------
        */

        $this->command->info(
            'Roles and permissions created successfully.'
        );
    }
}