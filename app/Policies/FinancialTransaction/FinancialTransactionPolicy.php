<?php

namespace App\Policies\FinancialTransaction;

use App\Models\FinancialTransaction;
use App\Models\User;

class FinancialTransactionPolicy
{
    /*
    |--------------------------------------------------------------------------
    | View Any
    |--------------------------------------------------------------------------
    */

    public function viewAny(User $user): bool
    {
        return $user->can('financial_transactions.view');
    }

    /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    */

    public function view(
        User $user,
        FinancialTransaction $transaction
    ): bool {
        return $user->can('financial_transactions.view');
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create(User $user): bool
    {
        return $user->can('financial_transactions.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Create Income
    |--------------------------------------------------------------------------
    */

    public function createIncome(User $user): bool
    {
        return $user->can('financial_transactions.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Create Expense
    |--------------------------------------------------------------------------
    */

    public function createExpense(User $user): bool
    {
        return $user->hasRole('admin')
            && $user->can('financial_transactions.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        User $user,
        FinancialTransaction $transaction
    ): bool {

        return $user->can('financial_transactions.edit');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function delete(
        User $user,
        FinancialTransaction $transaction
    ): bool {

        return $user->can('financial_transactions.delete');
    }
}