<?php

namespace App\Services\TimeSlot;

use App\Models\TimeSlot;
use App\Models\User;
use App\Notifications\TimeSlotNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class DeleteTimeSlotService
{
    public function delete(TimeSlot $timeSlot)
    {
        $timeSlot->delete();
        $users = User::where('id', '!=', Auth::id())->get();
        Notification::send($users, new TimeSlotNotification($timeSlot, Auth::user(), 'Delete'));

        return $timeSlot;
    }
}
