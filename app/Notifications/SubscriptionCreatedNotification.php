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

        return [
            'type' => 'subscription_created',
            'title' => 'تم إنشاء اشتراك جديد',
            'message' => $subscription->registration_type === 'renew'
                ? 'تم تجديد اشتراكك بنجاح.'
                : 'تم إنشاء اشتراكك بنجاح.',
            'subscription_id' => $subscription->id,
            'sub_type' => $subscription->sub_type,
            'start_date' => $subscription->start_date?->toDateString(),
            'end_date' => $subscription->end_date?->toDateString(),
            'url' => route('subscriptions.show', $subscription),
        ];
    }
}
