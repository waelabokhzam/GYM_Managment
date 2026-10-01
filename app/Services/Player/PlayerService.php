<?php

namespace App\Services\Player;

use App\Models\Player;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class PlayerService
{
    /**
     * إنشاء لاعب جديد مع الحساب الخاص به.
     */
    public function createPlayer(array $data): Player
    {
        return DB::transaction(function () use ($data) {

            // إنشاء username فريد
            $username = $this->generateUniqueUsername();

            // إنشاء رقم لاعب فريد
            $uniqueNumber = $this->generateUniqueNumber();

            // إنشاء حساب المستخدم
            $user = User::create([
                'fullname' => $data['fullname'],
                'phone' => $data['phone'],
                'username' => $username,
                'password' => Hash::make($data['password']),
            ]);

            // إعطاء الحساب صلاحية لاعب
            $user->assignRole('player');

            // إنشاء بيانات اللاعب
            $player = Player::create([
                'user_id' => $user->id,
                'unique_number' => $uniqueNumber,
                'gender' => $data['gender'],
                'height' => $data['height'] ?? null,
                'weight' => $data['weight'] ?? null,
                'occupation' => $data['occupation'] ?? null,
                'health_status' => $data['health_status'] ?? null,
            ]);

            return $player;
        });
    }

    /**
     * توليد username بالشكل:
     * gym_XXXXXX
     */
    private function generateUniqueUsername(): string
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

        do {
            $suffix = '';

            for ($i = 0; $i < 6; $i++) {
                $suffix .= $characters[
                    random_int(0, strlen($characters) - 1)
                ];
            }

            $username = 'gym_' . $suffix;

        } while (
            User::where('username', $username)->exists()
        );

        return $username;
    }
    public function updatePlayer(
        Player $player,
        array $data
    ): Player {
        return DB::transaction(function () use ($player, $data) {

            $player->user->update([
                'fullname' => $data['fullname'],
                'phone' => $data['phone'],
            ]);

            $player->update([
                'gender' => $data['gender'],
                'height' => $data['height'] ?? null,
                'weight' => $data['weight'] ?? null,
                'occupation' => $data['occupation'] ?? null,
                'health_status' => $data['health_status'] ?? null,
            ]);

            return $player->refresh();
        });
    }

    /**
     * حذف لاعب
     */
    public function deletePlayer(Player $player): void
    {
        DB::transaction(function () use ($player) {

            $user = $player->user;

            $player->delete();

            $user->delete();
        });
    }

    /**
     * توليد رقم لاعب بالشكل:
     * PL123456
     */
    private function generateUniqueNumber(): string
    {
        do {
            $uniqueNumber = 'PL' . str_pad(
                (string) random_int(1, 999999),
                6,
                '0',
                STR_PAD_LEFT
            );

        } while (
            Player::where('unique_number', $uniqueNumber)->exists()
        );

        return $uniqueNumber;
    }
}