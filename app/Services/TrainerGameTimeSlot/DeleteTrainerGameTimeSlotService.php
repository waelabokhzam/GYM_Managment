<?php

namespace App\Services\TrainerGameTimeSlot;

use App\Models\TrainerGameTimeSlot;
use Illuminate\Support\Facades\DB;

class DeleteTrainerGameTimeSlotService
{
    public function delete(
        TrainerGameTimeSlot $assignment
    ): bool {

        return DB::transaction(function () use ($assignment) {
            return $assignment->delete();
        });
    }
}