<?php

namespace App\Http\Requests\Subscription;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
         return [
            'sub_type' => ['required', 'in:special,offers,daily,monthly'],
            'status' => ['required', 'in:active,expired'],
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:99999999.99'
            ],
            // ⬅️ إضافة
            'trainer_id' => ['required_if:sub_type,special', 'nullable', 'exists:staff,id'],
        ];
    }
}
