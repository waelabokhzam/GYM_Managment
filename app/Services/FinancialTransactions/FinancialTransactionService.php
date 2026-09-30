<?php

namespace App\Services\FinancialTransactions;

use App\Models\FinancialTransaction;
use Illuminate\Support\Facades\DB;

class FinancialTransactionService
{
    public function create(array $data): FinancialTransaction
    {
        return DB::transaction(function () use ($data) {

            $data['approved_by'] = auth()->id();

            return FinancialTransaction::create($data);
        });
    }

    public function update(
        FinancialTransaction $transaction,
        array $data
    ): FinancialTransaction {

        return DB::transaction(function () use (
            $transaction,
            $data
        ) {

            /*
            |--------------------------------------------------------------------------
            | لا نغير approved_by عند التعديل
            |--------------------------------------------------------------------------
            */

            $transaction->update([
                'transaction_type' => $data['transaction_type'],
                'amount' => $data['amount'],
                'description' => $data['description'],
            ]);

            return $transaction->fresh('approver');
        });
    }

    public function delete(
        FinancialTransaction $transaction
    ): bool {

        return DB::transaction(function () use ($transaction) {

            return $transaction->delete();
        });
    }
}