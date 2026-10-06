<?php

namespace App\Http\Requests\Subscription;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'player_id' => ['required', 'exists:players,id'],
            'sub_type' => ['required', 'in:special,offers,daily,monthly'],
            'registration_type' => ['required', 'in:new,renew'],
            'start_date' => ['nullable', 'date'],
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:99999999.99'
            ],
            // ⬅️ إضافة: مطلوبة بس لما sub_type = special
            'trainer_id' => ['required_if:sub_type,special', 'nullable', 'exists:staff,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'player_id' => 'اللاعب',
            'sub_type' => 'نوع الاشتراك',
            'registration_type' => 'نوع التسجيل',
            'start_date' => 'تاريخ البداية',
            'amount' => 'مبلغ الاشتراك',
            'trainer_id' => 'المدرب', // ⬅️ إضافة
        ];
    }
}
