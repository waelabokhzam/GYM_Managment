<?php

namespace App\Services\Subscription;

use App\Models\Subscription;
use App\Models\FinancialTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    public function create(array $data): Subscription
    {
        return DB::transaction(function () use ($data) {

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

            $lastSubscription = Subscription::where('player_id', $data['player_id'])
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

            /*
            |--------------------------------------------------------------------------
            | إنشاء الاشتراك
            |--------------------------------------------------------------------------
            */

            $subscription = Subscription::create([
                'player_id' => $data['player_id'],
                'sub_type' => $data['sub_type'],
                'registration_type' => $data['registration_type'],
                'amount' => $data['amount'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
            ]);

            /*
            |--------------------------------------------------------------------------
            | جلب اسم اللاعب
            |--------------------------------------------------------------------------
            */

            $subscription->load('player.user');

            $unique_number = $subscription->player->unique_number;

            /*
            |--------------------------------------------------------------------------
            | إنشاء المعاملة المالية
            |--------------------------------------------------------------------------
            */

            FinancialTransaction::create([
                'transaction_type' => 'income',
                'amount' => $data['amount'],
                'description' => 'دفع اشتراك اللاعب: ' . $unique_number,
                'approved_by' => auth()->id(),
            ]);

            return $subscription;
        });
    }

    public function update(Subscription $subscription, array $data): bool
    {
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