<?php

namespace App\Services\Subscription;

use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionService
{
    public function create(array $data): Subscription
    {
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

        return Subscription::create([
            'player_id' => $data['player_id'],
            'sub_type' => $data['sub_type'],
            'registration_type' => $data['registration_type'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
        ]);
    }

    public function update(Subscription $subscription, array $data): bool
    {
        return $subscription->update($data);
    }

    public function delete(Subscription $subscription): bool
    {
        return $subscription->delete();
    }
}