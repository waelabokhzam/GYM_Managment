<?php
namespace App\Http\Requests\Users;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
        $role = $this->input('role');

        return [

        'fullname' => [
            'required',
            'string',
            'max:255',
        ],

        'phone' => [
            'required',
            'string',
            'max:30',
            'unique:users,phone',
        ],

        'role' => [
            'required',
            'string',
            'exists:roles,name',
        ],

        'password' => [
            'required',
            'confirmed',
            'min:8',
        ],

        'salary_type' => [
            'nullable',
            'in:fixed,percentage',
        ],

        'base_salary' => [
            'nullable',
            'numeric',
            'min:0',
        ],

        'unique_number' => [
            'nullable',
            'string',
            'max:255',
        ],

        'gender' => [
            'nullable',
            'in:male,female',
        ],

        'height' => [
            'nullable',
            'numeric',
            'min:0',
        ],

        'weight' => [
            'nullable',
            'numeric',
            'min:0',
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
    public function attributes(): array
    {
        return [
            'fullname' => 'الاسم الكامل',
            'phone' => 'رقم الهاتف',
            'password' => 'كلمة المرور',
            'salary_type' => 'نوع الأجر',
            'base_salary' => 'الأجر الأساسي',
            'unique_number' => 'الرقم الخاص',
            'height' => 'الطول',
            'weight' => 'الوزن',
            'health_status' => 'الحالة الصحية',
            'occupation' => 'المهنة',
            'gender' => 'الجنس',
            'role' => 'الصلاحية',
        ];
    }
}
