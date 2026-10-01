<?php

namespace App\Http\Requests\Player;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePlayerRequest extends FormRequest
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
            'fullname' => [
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'gender' => [
                'required',
                'in:male,female',
            ],

            'height' => [
                'nullable',
                'numeric',
                'min:0',
                'max:300',
            ],

            'weight' => [
                'nullable',
                'numeric',
                'min:0',
                'max:500',
            ],

            'occupation' => [
                'nullable',
                'string',
                'max:255',
            ],

            'health_status' => [
                'nullable',
                'string',
            ],
        ];
    }

     public function messages(): array
    {
        return [
            'fullname.required' => 'الاسم الكامل مطلوب.',
            'fullname.string' => 'الاسم الكامل يجب أن يكون نصاً.',
            'fullname.max' => 'الاسم الكامل طويل جداً.',

            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.max' => 'رقم الهاتف طويل جداً.',

            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',

            'gender.required' => 'الجنس مطلوب.',
            'gender.in' => 'قيمة الجنس غير صحيحة.',

            'height.numeric' => 'الطول يجب أن يكون رقماً.',
            'height.min' => 'الطول لا يمكن أن يكون سالباً.',
            'height.max' => 'الطول غير منطقي.',

            'weight.numeric' => 'الوزن يجب أن يكون رقماً.',
            'weight.min' => 'الوزن لا يمكن أن يكون سالباً.',
            'weight.max' => 'الوزن غير منطقي.',

            'occupation.string' => 'المهنة يجب أن تكون نصاً.',
            'health_status.string' => 'الحالة الصحية يجب أن تكون نصاً.',
        ];
    }

    /**
     * تنظيف البيانات قبل إرسالها إلى Service
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'fullname' => trim((string) $this->fullname),
            'phone' => trim((string) $this->phone),
            'occupation' => $this->occupation
                ? trim((string) $this->occupation)
                : null,
            'health_status' => $this->health_status
                ? trim((string) $this->health_status)
                : null,
        ]);
    }
}
