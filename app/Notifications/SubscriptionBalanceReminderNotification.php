<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SubscriptionBalanceReminderNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Subscription $subscription,
        public float $remainingAmount
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $isPlayer = method_exists($notifiable, 'hasRole')
            && $notifiable->hasRole('player');

        return [
            'type' => 'subscription_balance_reminder',
            'title' => 'تذكير بالمبلغ المتبقي للاشتراك',

            'message' => $isPlayer
                ? 'يرجى تسديد المبلغ المتبقي من اشتراكك وقدره '
                    . number_format($this->remainingAmount, 0)
                    . ' ليرة سورية.'
                : 'يوجد مبلغ متبقٍ على اشتراك اللاعب رقم '
                    . $this->subscription->player_id
                    . ' وقدره '
                    . number_format($this->remainingAmount, 0)
                    . ' ليرة سورية.',

            'subscription_id' => $this->subscription->id,
            'player_id' => $this->subscription->player_id,
            'remaining_amount' => $this->remainingAmount,
            'url' => route('subscriptions.show', $this->subscription),
        ];
    }
}
