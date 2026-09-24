<?php

namespace App\Services\Trainer;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TrainerService
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function getTrainers(?string $search = null,int $perPage = 10): LengthAwarePaginator {

        return Staff::query()
            ->with('user')
            ->where('role', 'trainer')
            ->when($search, function ($query) use ($search) {

                $query->whereHas('user', function ($userQuery) use ($search) {

                    $userQuery
                        ->where('fullname', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");

                });

            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }


    /*
    |--------------------------------------------------------------------------
    | Get Trainer
    |--------------------------------------------------------------------------
    */

    public function findTrainer(int $id): Staff
    {
        return Staff::query()
            ->with('user')
            ->trainers()
            ->findOrFail($id);
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function createTrainer(array $data): Staff
    {
        return DB::transaction(function () use ($data) {

            $username = $this->generateUniqueUsername();

            $user = User::create([
                'fullname' => $data['fullname'],
                'phone' => $data['phone'],
                'username' => $username,
                'password' => Hash::make($data['password']),
            ]);

            $trainer=  Staff::create([
                'user_id' => $user->id,
                'role' => 'trainer',
                'salary_type' => $data['salary_type'],
                'base_salary' => $data['base_salary'] ?? 0,
            ]);
            $trainer->user->assignRole('trainer');
            return $trainer;
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function updateTrainer(
        Staff $trainer,
        array $data
    ): Staff {

        return DB::transaction(function () use ($trainer, $data) {

            $user = $trainer->user;

            $user->update([
                'fullname' => $data['fullname'],
                'phone' => $data['phone'],
            ]);

            if (!empty($data['password'])) {

                $user->update([
                    'password' => Hash::make($data['password']),
                ]);

            }

            $trainer->update([
                'salary_type' => $data['salary_type'],
                'base_salary' => $data['base_salary'] ?? 0,
            ]);

            return $trainer->fresh([
                'user',
            ]);
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function deleteTrainer(Staff $trainer): void
    {
        DB::transaction(function () use ($trainer) {

            $user = $trainer->user;

            $trainer->delete();

            if ($user) {
                $user->delete();
            }
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Generate Username
    |--------------------------------------------------------------------------
    */

    private function generateUniqueUsername(): string
    {
        do {

            $username =
                'gym_' .
                strtoupper(
                    Str::random(6)
                );

        } while (
            User::where('username', $username)->exists()
        );

        return $username;
    }
}