<?php

namespace App\Services\TimeSlot;

use App\Models\TimeSlot;
use App\Models\User;
use App\Notifications\TimeSlotNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class UpdateTimeSlotService
{
    public function update(array $data, TimeSlot $timeSlot)
    {
        $timeSlot->update($data);
        $users = User::where('id', '!=', Auth::id())->get();
        Notification::send($users, new TimeSlotNotification($timeSlot, Auth::user(), 'Update'));

        return $timeSlot;
    }
}
