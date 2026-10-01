<?php

namespace App\Http\Requests\Trainer;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTrainerRequest extends FormRequest
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
                'min:3',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
                'unique:users,phone',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'salary_type' => [
                'required',
                Rule::in([
                    'fixed',
                    'percentage',
                ]),
            ],

            'base_salary' => [
                'nullable',
                'numeric',
                'min:0',
            ],

        ];

    }
     public function messages(): array
    {
        return [

            'fullname.required' =>
                'يرجى إدخال اسم المدرب.',

            'fullname.min' =>
                'يجب أن يحتوي الاسم على 3 أحرف على الأقل.',

            'phone.required' =>
                'يرجى إدخال رقم الهاتف.',

            'phone.unique' =>
                'رقم الهاتف مستخدم مسبقاً.',

            'password.required' =>
                'يرجى إدخال كلمة المرور.',

            'password.min' =>
                'يجب أن تحتوي كلمة المرور على 8 أحرف على الأقل.',

            'password.confirmed' =>
                'تأكيد كلمة المرور غير مطابق.',

            'salary_type.required' =>
                'يرجى اختيار نوع الأجر.',

            'salary_type.in' =>
                'نوع الأجر غير صالح.',

            'base_salary.numeric' =>
                'قيمة الأجر يجب أن تكون رقماً.',

        ];
    }
}
