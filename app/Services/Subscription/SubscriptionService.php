<?php

namespace App\Services\Subscription;

use App\Models\Subscription;
use App\Notifications\SubscriptionCreatedNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    public function create(array $data): Subscription
    {
        // إنشاء الاشتراك ضمن معاملة قاعدة البيانات
        $subscription = DB::transaction(function () use ($data) {

            $today = Carbon::today();

            $requestedDate = isset($data['start_date'])
                ? Carbon::parse($data['start_date'])
                : $today;

            $duration = match ($data['sub_type']) {
                'daily' => 1,
                'monthly' => 30,
                'offers' => 30,
                'special' => 30,
            };

            $lastSubscription = Subscription::where(
                'player_id',
                $data['player_id']
            )
                ->latest('end_date')
                ->first();

            if (
                $data['registration_type'] === 'renew'
                && $lastSubscription
                && $lastSubscription->end_date->greaterThan($today)
            ) {
                $startDate = $lastSubscription->end_date->copy();
            } else {
                $startDate = $requestedDate;
            }

            $endDate = $startDate->copy()->addDays($duration);

            $subscription = Subscription::create([
                'player_id' => $data['player_id'],
                'sub_type' => $data['sub_type'],
                'registration_type' => $data['registration_type'],
                'amount' => $data['amount'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
            ]);

            // تحميل اللاعب وحسابه
            $subscription->load('player.user');

            // إعادة الاشتراك ليتم استخدامه بعد نجاح المعاملة
            return $subscription;
        });

        // إرسال الإشعار بعد نجاح حفظ الاشتراك
        $playerUser = $subscription->player?->user;

        if ($playerUser) {
            $playerUser->notify(
                new SubscriptionCreatedNotification($subscription)
            );
        }

        return $subscription;
    }

    public function update(
        Subscription $subscription,
        array $data
    ): bool {
        return $subscription->update([
            'sub_type' => $data['sub_type'],
            'amount' => $data['amount'],
            'status' => $data['status'],
        ]);
    }

    public function delete(Subscription $subscription): bool
    {
        return DB::transaction(function () use ($subscription) {
            return $subscription->delete();
        });
    }
}