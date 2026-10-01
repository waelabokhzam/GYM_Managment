<?php

namespace App\Services\Receipt;

use App\Models\Receipt;
use Illuminate\Support\Facades\Auth;

class CreateReceiptService
{
    public function create(array $data)
    {
        $receipt = Receipt::create([
            'game_id' => $data['game_id'],
            'subscription_id' => $data['subscription_id'],
            'player_id' => $data['player_id'],
            'received_by' => Auth::user()->staff->id,
            'amount' => $data['amount'],
            'payment_date' => $data['payment_date'],
        ]);

        return $receipt;
    }
}