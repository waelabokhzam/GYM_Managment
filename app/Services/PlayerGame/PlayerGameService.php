<?php

namespace App\Services\PlayerGame;

use App\Models\PlayerGame;
use Illuminate\Support\Facades\DB;

class PlayerGameService
{
    public function create(array $data): PlayerGame
    {
        return DB::transaction(function () use ($data) {

            return PlayerGame::create($data);

        });
    }

    public function update(
        PlayerGame $playerGame,
        array $data
    ): PlayerGame {

        return DB::transaction(function () use ($playerGame, $data) {

            $playerGame->update($data);

            return $playerGame;

        });
    }

    public function delete(PlayerGame $playerGame): bool
    {
        return DB::transaction(function () use ($playerGame) {

            return $playerGame->delete();

        });
    }
}