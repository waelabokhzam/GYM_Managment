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
        // تنظيف الكاش الخاص بالصلاحيات
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [

            // Members
            'members.view',
            'members.create',
            'members.edit',
            'members.delete',

            // Subscriptions
            'subscriptions.view',
            'subscriptions.create',
            'subscriptions.edit',
            'subscriptions.delete',

            // Trainers
            'trainers.view',
            'trainers.create',
            'trainers.edit',
            'trainers.delete',

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

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name'       => $permission,
                'guard_name' => 'web',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $admin = Role::firstOrCreate([
            'name'       => 'admin',
            'guard_name' => 'web',
        ]);

        $reception = Role::firstOrCreate([
            'name'       => 'reception',
            'guard_name' => 'web',
        ]);

        $trainer = Role::firstOrCreate([
            'name'       => 'trainer',
            'guard_name' => 'web',
        ]);

        $player = Role::firstOrCreate([
            'name'       => 'player',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        |
        | Admin يمتلك جميع الصلاحيات الموجودة في النظام.
        |
        */

        $admin->syncPermissions(
            Permission::all()
        );

        /*
        |--------------------------------------------------------------------------
        | Reception
        |--------------------------------------------------------------------------
        */

        $reception->syncPermissions([
            'members.view',
            'members.create',
            'members.edit',

            'subscriptions.view',
            'subscriptions.create',
            'subscriptions.edit',

            'trainers.view',

            'training_periods.view',

            'sports.view',

            'payments.view',
            'payments.create',

            'attendance.view',
            'attendance.create',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Trainer
        |--------------------------------------------------------------------------
        */

        $trainer->syncPermissions([
            'members.view',

            'subscriptions.view',

            'trainers.view',

            'training_periods.view',

            'sports.view',

            'attendance.view',
            'attendance.create',
            'attendance.edit',

            'reports.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Player
        |--------------------------------------------------------------------------
        */

        $player->syncPermissions([
            'members.view',

            'subscriptions.view',

            'training_periods.view',

            'sports.view',

            'attendance.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Clear permission cache
        |--------------------------------------------------------------------------
        */

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('Roles and permissions created successfully.');
    }
}
