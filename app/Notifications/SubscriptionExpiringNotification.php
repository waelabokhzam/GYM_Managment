<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SubscriptionExpiringNotification extends Notification
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

        return [
            'type' => 'subscription_expiring',
            'title' => 'اشتراك على وشك الانتهاء',
            'message' => $notifiable->hasRole('player')
    ? 'ينتهي اشتراكك بتاريخ '
        . $subscription->end_date?->format('Y-m-d')
        . '. يرجى مراجعة الاستقبال لتجديد الاشتراك.'
    : 'اشتراك اللاعب '
        . ($subscription->player?->user?->fullname ?? 'غير معروف')
        . ' سينتهي بتاريخ '
        . $subscription->end_date?->format('Y-m-d')
        . '. يرجى متابعة التجديد.',
            'subscription_id' => $subscription->id,
            'player_id' => $subscription->player_id,
            'end_date' => $subscription->end_date?->toDateString(),
            'url' => route('subscriptions.show', $subscription),
        ];
    }
}
