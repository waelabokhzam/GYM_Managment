<?php

namespace App\Http\Requests\FinancialTransactions;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFinancialTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'transaction_type' => [
                'required',
                Rule::in([
                    'income',
                    'expense',
                ]),
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:9999999999.99',
            ],

            'description' => [
                'required',
                'string',
                'max:2000',
            ],
        ];
    }
    public function attributes(): array
    {
        return [
            'transaction_type' => 'نوع الحركة المالية',
            'amount' => 'المبلغ',
            'description' => 'سبب الحركة المالية',
        ];
    }
}
