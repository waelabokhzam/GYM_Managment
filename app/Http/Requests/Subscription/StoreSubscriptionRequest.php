<?php

namespace App\Http\Requests\Subscription;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
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
            'player_id' => ['required', 'exists:players,id'],
            'sub_type' => ['required', 'in:special,offers,daily,monthly'],
            'registration_type' => ['required', 'in:new,renew'],
            'start_date' => ['nullable', 'date'],
        ];
    
    }

     public function attributes(): array
    {
        return [
            'player_id' => 'اللاعب',
            'sub_type' => 'نوع الاشتراك',
            'registration_type' => 'نوع التسجيل',
            'start_date' => 'تاريخ البداية',
        ];
    }
}
