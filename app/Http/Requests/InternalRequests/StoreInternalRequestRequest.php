<?php

namespace App\Http\Requests\InternalRequests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInternalRequestRequest extends FormRequest
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
            'details' => [
                'required',
                'string',
                'min:10',
            ],
        ];
    }
    public function attributes(): array
    {
        return [
            'details' => 'تفاصيل الطلب',
        ];
    }
}
