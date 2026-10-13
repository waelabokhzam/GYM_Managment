<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\User;
use App\Notifications\SubscriptionBalanceReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NotifySubscriptionBalanceReminders extends Command
{
    protected $signature = 'subscriptions:notify-balance-reminders';

    protected $description =
        'Send reminders for unpaid subscription balances at mid-term';

    public function handle(): int
    {
        $staffUsers = User::role(['admin', 'reception'])->get();

        $sent = 0;

        Subscription::query()
            ->where('status', 'active')
            ->whereNull('balance_reminder_sent_at')
            ->with(['receipts', 'player.user'])
            ->chunkById(100, function ($subscriptions) use (
                $staffUsers,
                &$sent
            ) {
                foreach ($subscriptions as $subscription) {
                    DB::transaction(function () use (
                        $subscription,
                        $staffUsers,
                        &$sent
                    ) {
                        $locked = Subscription::query()
                            ->whereKey($subscription->id)
                            ->lockForUpdate()
                            ->first();

                        if (
                            !$locked ||
                            $locked->status !== 'active' ||
                            $locked->balance_reminder_sent_at !== null
                        ) {
                            return;
                        }

                        $locked->load(['receipts', 'player.user']);

                        if (
                            !$locked->start_date ||
                            !$locked->end_date ||
                            $locked->end_date->lessThanOrEqualTo(
                                $locked->start_date
                            )
                        ) {
                            return;
                        }

                        // حساب منتصف مدة الاشتراك
                        $durationDays = (int) $locked->start_date
                            ->diffInDays($locked->end_date);

                        $midpoint = $locked->start_date
                            ->copy()
                            ->addDays((int) floor($durationDays / 2));

                        // لم يصل الاشتراك إلى منتصف مدته بعد
                        if (now()->startOfDay()->lt($midpoint)) {
                            return;
                        }

                        // حساب مجموع الدفعات المسجلة في الإيصالات
                        $paidAmount = (float) $locked->receipts
                            ->sum('amount');

                        $totalAmount = (float) $locked->amount;

                        $remainingAmount = round(
                            $totalAmount - $paidAmount,
                            2
                        );

                        // لا يوجد مبلغ متبقٍ
                        if ($remainingAmount <= 0) {
                            return;
                        }

                        $playerUser = $locked->player?->user;

                        if (!$playerUser) {
                            $this->warn(
                                "الاشتراك رقم {$locked->id} لا يرتبط بحساب لاعب."
                            );

                            return;
                        }

                        // إشعار اللاعب
                        $notification =
                            new SubscriptionBalanceReminderNotification(
                                $locked,
                                $remainingAmount
                            );

                        $playerUser->notify($notification);

                        // إشعار الأدمن والاستقبال، دون تكرار للاعب نفسه
                        foreach ($staffUsers as $staffUser) {
                            if ($staffUser->is($playerUser)) {
                                continue;
                            }

                            $staffUser->notify($notification);
                        }

                        // تسجيل وقت الإرسال لمنع التكرار
                        $locked->update([
                            'balance_reminder_sent_at' => now(),
                        ]);

                        $sent++;
                    });
                }
            });

        $this->info(
            "تم إرسال تذكيرات المبالغ المتبقية لعدد {$sent} اشتراك."
        );

        return self::SUCCESS;
    }
}
