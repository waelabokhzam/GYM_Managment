<?php

namespace App\Services\TrainerGameTimeSlot;

use App\Models\TrainerGameTimeSlot;
use Illuminate\Support\Facades\DB;

class UpdateTrainerGameTimeSlotService
{
    public function update(
        array $data,
        TrainerGameTimeSlot $assignment
    ): TrainerGameTimeSlot {

        return DB::transaction(function () use (
            $data,
            $assignment
        ) {

            $assignment->update([
                'staff_id' => $data['staff_id'],
                'game_id' => $data['game_id'],
                'time_slot_id' => $data['time_slot_id'],
            ]);

            return $assignment->refresh();
        });
    }
}