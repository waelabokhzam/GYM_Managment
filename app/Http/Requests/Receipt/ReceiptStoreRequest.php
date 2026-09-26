<?php

namespace App\Http\Requests\Receipt;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReceiptStoreRequest extends FormRequest
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
            'game_id' => ['required', 'exists:games,id'],
            'subscription_id' => ['required', 'exists:subscriptions,id'],
            'player_id' => ['required', 'exists:players,id'],
            'received_by' => ['required', 'exists:staff,id'],
            'amount' => ['required', 'decimal:0'],
            'payment_date' => ['required', 'date'],
        ];
    }
}
