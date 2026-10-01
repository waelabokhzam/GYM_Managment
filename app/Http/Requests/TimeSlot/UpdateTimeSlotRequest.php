<?php

namespace App\Http\Requests\TimeSlot;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTimeSlotRequest extends FormRequest
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
            'start_time' => ['sometimes', 'string'],
            'end_time' => ['sometimes', 'string'],
            'gender_type' => ['sometimes', 'in:women_only,mixed'],
        ];
    }
}
