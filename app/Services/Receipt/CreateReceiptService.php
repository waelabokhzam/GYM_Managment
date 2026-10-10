<?php

namespace App\Services\Receipt;

use App\Models\FinancialTransaction;
use App\Models\Player;
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

        /*
            |--------------------------------------------------------------------------
            | إنشاء المعاملة المالية
            |--------------------------------------------------------------------------
            */
            $unique_number = Player::where('id', $data['player_id'])->value('unique_number');
            FinancialTransaction::create([
                'transaction_type' => 'income',
                'amount' => $data['amount'],
                'description' => 'دفع اشتراك اللاعب: ' . $unique_number,
                'approved_by' => auth()->id(),
            ]);

        return $receipt;
    }
}