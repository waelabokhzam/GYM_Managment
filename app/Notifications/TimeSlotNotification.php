<?php

namespace App\Notifications;

use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TimeSlotNotification extends Notification
{
    use Queueable;

    public TimeSlot $timeSlot;

    public User $user;

    public string $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(TimeSlot $timeSlot, User $user, string $message)
    {
        $this->timeSlot = $timeSlot;
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'timeslot' => $this->timeSlot,
            'message' => 'The user '.$this->user->name.' '.$this->message.' TimeSlot',
            'by' => $this->user->name,
        ];
    }
}
