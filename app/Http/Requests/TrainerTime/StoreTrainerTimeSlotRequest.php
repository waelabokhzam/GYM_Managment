<?php

namespace App\Http\Requests\TrainerTime;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTrainerTimeSlotRequest extends FormRequest
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
        'staff_id' => [
            'required',
            Rule::exists('staff', 'id')->where('role', 'trainer'),
        ],

        'time_slot_id' => [
            'required',
            'exists:time_slots,id',
            Rule::unique('trainer_time_slots')
                ->where(fn ($query) => $query->where('staff_id', $this->staff_id)),
        ],
    ];
    }
    public function messages(): array
    {
        return [
            'time_slot_id.unique' => 'هذا المدرب مرتبط بهذه الفترة مسبقًا.',
            'staff_id.exists' => 'المدرب المحدد غير صالح.',
            'time_slot_id.exists' => 'الفترة المحددة غير موجودة.',
        ];
    }
}
