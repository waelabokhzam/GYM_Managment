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
        return [
        'database',
        \App\Notifications\Channels\FcmChannel::class,
    ];
    }

    public function toArray(object $notifiable): array
    {
        $subscription = $this->subscription;

        $playerName = $subscription->player?->user?->fullname ?? 'لاعب غير معروف';

        $creatorName = $subscription->createdBy?->fullname ?? 'غير محدد';

        $isPlayer = method_exists($notifiable, 'hasRole')
        && $notifiable->hasRole('player');

        return [
            'type'    => 'subscription_expiring',

            'title'   => 'اشتراك على وشك الانتهاء',

            'message' => $isPlayer
                ? "ينتهي اشتراكك بتاريخ {$subscription->end_date?->format('Y-m-d')}. يرجى مراجعة الاستقبال لتجديد الاشتراك."
                : "اللاعب: {$playerName} | ينتهي الاشتراك بتاريخ {$subscription->end_date?->format('Y-m-d')} | الموظف الذي أنشأ الاشتراك: {$creatorName}",

            'subscription_id' => $subscription->id,

            'player_id' => $subscription->player_id,

            'end_date' => $subscription->end_date?->toDateString(),

            'url' => route('players.show', $subscription->player_id),
        ];
    }


public function toFcm(object $notifiable): array
{
    $data = $this->toArray($notifiable);

    return [
        'title' => $data['title'],
        'body' => $data['message'],
        'data' => [
            'type' => $data['type'],
            'subscription_id' => (string) $this->subscription->id,
        ],
    ];
}

}
