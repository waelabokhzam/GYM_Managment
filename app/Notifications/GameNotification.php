<?php

namespace App\Notifications;

use App\Models\Game;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GameNotification extends Notification
{
    use Queueable;

    public Game $game;
    public User $user;
    public string $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Game $game, string $message, User $user)
    {
        $this->game = $game;
        $this->message = $message;
        $this->user = $user;
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
            "game" => $this->game,
            "message" => "The user " . $this->user->name . " " . $this->message . " {$this->game->name} Game",
            "by" => $this->user->name
        ];
    }
}
