<?php

namespace App\Services\TimeSlot;

use App\Models\TimeSlot;
use App\Models\User;
use App\Notifications\TimeSlotNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CreateTimeSlotService
{
    public function create(array $data)
    {
        $timeslot = TimeSlot::create($data);
        $users = User::where('id', '!=', Auth::id())->get();
        Notification::send($users, new TimeSlotNotification($timeslot, Auth::user(), 'Create'));

        return $timeslot;

    }
}
