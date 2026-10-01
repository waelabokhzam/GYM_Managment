<?php

namespace App\Services\TrainerTime;

use App\Models\TrainerTimeSlot;
use Illuminate\Support\Facades\DB;

class TrainerTimeSlotService
{
    public function create(array $data): TrainerTimeSlot
    {
        return DB::transaction(function () use ($data) {

            return TrainerTimeSlot::create($data);

        });
    }

    public function update(
        TrainerTimeSlot $trainerTimeSlot,
        array $data
    ): TrainerTimeSlot {

        return DB::transaction(function () use ($trainerTimeSlot, $data) {

            $trainerTimeSlot->update($data);

            return $trainerTimeSlot;

        });
    }

    public function delete(
        TrainerTimeSlot $trainerTimeSlot
    ): bool {

        return DB::transaction(function () use ($trainerTimeSlot) {

            return $trainerTimeSlot->delete();

        });
    }
}