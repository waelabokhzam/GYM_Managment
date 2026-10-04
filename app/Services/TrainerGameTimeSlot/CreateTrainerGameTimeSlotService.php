<?php

namespace App\Services\TrainerGameTimeSlot;

use App\Models\TrainerGameTimeSlot;
use Illuminate\Support\Facades\DB;

class CreateTrainerGameTimeSlotService
{
    public function create(array $data): TrainerGameTimeSlot
    {
        return DB::transaction(function () use ($data) {

            return TrainerGameTimeSlot::create([
                'staff_id' => $data['staff_id'],
                'game_id' => $data['game_id'],
                'time_slot_id' => $data['time_slot_id'],
            ]);
        });
    }
}