<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SubscriptionCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Subscription $subscription
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $subscription = $this->subscription;

        $playerName = $subscription->player?->user?->fullname
            ?? 'لاعب غير معروف';

        $creatorName = $subscription->createdBy?->fullname
            ?? 'غير محدد';

        return [
            'type' => 'subscription_created',

            'title' => 'تم إنشاء اشتراك جديد',

            'message' => "اللاعب: {$playerName} | الموظف الذي أنشأ الاشتراك: {$creatorName}",

            'player_id' => $subscription->player_id,

            'subscription_id' => $subscription->id,

            'url' => route('players.show', $subscription->player_id),
        ];
    }
}
