<?php

namespace App\Http\Requests\Receipt;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReceiptUpdateRequest extends FormRequest
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
            'game_id' => ['sometimes', 'exists:games,id'],
            'subscription_id' => ['sometimes', 'exists:subscriptions,id'],
            'player_id' => ['sometimes', 'exists:players,id'],
            'received_by' => ['sometimes', 'exists:staff,id'],
            'amount' => ['sometimes', 'decimal:0'],
            'payment_date' => ['sometimes', 'date'],
        ];
    }
}
