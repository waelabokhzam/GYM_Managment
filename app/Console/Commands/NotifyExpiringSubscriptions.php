<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\User;
use App\Notifications\SubscriptionExpiringNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NotifyExpiringSubscriptions extends Command
{
    protected $signature = 'subscriptions:notify-expiring';

    protected $description = 'Send notifications for subscriptions expiring in three days';

    public function handle(): int
    {
        $targetDate = now()->startOfDay()->addDays(3)->toDateString();

        $staff = User::role(['admin', 'reception'])->get();

        $sent = 0;

        Subscription::query()
            ->where('status', 'active')
            ->whereDate('end_date', $targetDate)
            ->whereNull('expiry_notification_sent_at')
            ->with(['player.user'])
            ->chunkById(100, function ($subscriptions) use ($staff, &$sent) {
                foreach ($subscriptions as $subscription) {
                    DB::transaction(function () use (
                        $subscription,
                        $staff,
                        &$sent
                    ) {
                        $locked = Subscription::query()
                            ->whereKey($subscription->id)
                            ->lockForUpdate()
                            ->first();

                        if (
                            !$locked ||
                            $locked->status !== 'active' ||
                            $locked->expiry_notification_sent_at !== null ||
                            !$locked->end_date?->isSameDay(now()->startOfDay()->addDays(3))
                        ) {
                            return;
                        }

                        $locked->loadMissing(['player.user']);

                        $playerUser = $locked->player?->user;

                        if (!$playerUser) {
                            $this->warn(
                                "لم يتم العثور على مستخدم للاعب صاحب الاشتراك رقم {$locked->id}."
                            );

                            return;
                        }

                        // إشعار اللاعب.
                        $playerUser->notify(
                            new SubscriptionExpiringNotification($locked)
                        );

                        // إشعار الإدارة والاستقبال.
                        foreach ($staff as $user) {
                            $user->notify(
                                new SubscriptionExpiringNotification($locked)
                            );
                        }

                        $locked->update([
                            'expiry_notification_sent_at' => now(),
                        ]);

                        $sent++;
                    });
                }
            });

        $this->info("تم إرسال إشعارات قرب انتهاء الاشتراك لعدد {$sent} اشتراك.");

        return self::SUCCESS;
    }
}
