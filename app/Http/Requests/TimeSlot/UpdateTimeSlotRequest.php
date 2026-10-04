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
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],

            'gender_type' => [
                'required',
                'in:women_only,mixed',
            ],

            'days' => [
                'required',
                'array',
                'min:1',
            ],

            'days.*' => [
                'required',
                'in:saturday,sunday,monday,tuesday,wednesday,thursday,friday',
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'اسم الفترة مطلوب.',

            'start_time.required' => 'وقت البداية مطلوب.',
            'start_time.date_format' => 'صيغة وقت البداية غير صحيحة.',

            'end_time.required' => 'وقت النهاية مطلوب.',
            'end_time.date_format' => 'صيغة وقت النهاية غير صحيحة.',
            'end_time.after' => 'يجب أن يكون وقت النهاية بعد وقت البداية.',

            'gender_type.required' => 'نوع الفترة مطلوب.',
            'gender_type.in' => 'نوع الفترة المحدد غير صحيح.',

            'days.required' => 'يجب تحديد يوم واحد على الأقل.',
            'days.array' => 'صيغة الأيام غير صحيحة.',
            'days.min' => 'يجب تحديد يوم واحد على الأقل.',

            'days.*.in' => 'أحد الأيام المحددة غير صحيح.',
        ];
    }
}
