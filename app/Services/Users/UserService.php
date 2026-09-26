<?php

namespace App\Services\Users;

use App\Models\Player;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    /**
     * إنشاء مستخدم جديد.
     */
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {

            $username = $this->generateUniqueUsername();

            $user = User::create([
                'fullname' => $data['fullname'],
                'username' => $username,
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Spatie Role
            |--------------------------------------------------------------------------
            */

            $user->assignRole($data['role']);

            /*
            |--------------------------------------------------------------------------
            | Role-specific data
            |--------------------------------------------------------------------------
            */

            $this->syncRoleData($user, $data['role'], $data);

            return $user;
        });
    }

    /**
     * تحديث مستخدم.
     */
    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {

            /*
            |--------------------------------------------------------------------------
            | Update basic information
            |--------------------------------------------------------------------------
            */

            $user->fullname = $data['fullname'];
            $user->phone = $data['phone'];

            if (!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }

            $user->save();

            /*
            |--------------------------------------------------------------------------
            | Current / New Role
            |--------------------------------------------------------------------------
            */

            $newRole = $data['role'];

            $currentRole = $user->getRoleNames()->first();

            /*
            |--------------------------------------------------------------------------
            | Role changed
            |--------------------------------------------------------------------------
            */

            if ($currentRole !== $newRole) {

                $user->syncRoles([
                    $newRole,
                ]);

                /*
                | Delete old role-specific data
                */

                $user->staff()?->delete();
                $user->player()?->delete();

            } else {

                /*
                | Remove any invalid old data
                */

                if ($newRole === 'player') {
                    $user->staff()?->delete();
                }

                if (in_array($newRole, [
                    'admin',
                    'reception',
                    'trainer',
                ])) {
                    $user->player()?->delete();
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Create / update role data
            |--------------------------------------------------------------------------
            */

            $this->syncRoleData(
                $user,
                $newRole,
                $data
            );

            return $user->fresh([
                'staff',
                'player',
                'roles',
            ]);
        });
    }

    /**
     * حذف المستخدم.
     */
    public function delete(User $user): bool
    {
        return DB::transaction(function () use ($user) {

            $user->staff()?->delete();
            $user->player()?->delete();

            $user->syncRoles([]);

            return (bool) $user->delete();
        });
    }

    /**
     * إنشاء أو تحديث بيانات Staff / Player.
     */
    private function syncRoleData(
        User $user,
        string $role,
        array $data
    ): void {

        if ($role === 'player') {

            Player::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'unique_number' => $data['unique_number'],
                    'height' => $data['height'] ?? null,
                    'weight' => $data['weight'] ?? null,
                    'health_status' => $data['health_status'] ?? null,
                    'occupation' => $data['occupation'] ?? null,
                    'gender' => $data['gender'],
                ]
            );

            return;
        }

        if (in_array($role, [
            'admin',
            'reception',
            'trainer',
        ])) {

            Staff::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'role' => $role,
                    'salary_type' => $data['salary_type'],
                    'base_salary' => $data['base_salary'],
                ]
            );
        }
    }

    /**
     * توليد Username.
     */
    private function generateUniqueUsername(): string
    {
        do {

            $username = 'gym_' .
                strtoupper(
                    Str::random(6)
                );

        } while (
            User::where('username', $username)->exists()
        );

        return $username;
    }
}