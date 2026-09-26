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
            /*
            |--------------------------------------------------------------------------
            | User
            |--------------------------------------------------------------------------
            */

            'fullname'      => [
                'required',
                'string',
                'max:255',
            ],

            'phone'         => [
                'required',
                'string',
                'max:30',
                'unique:users,phone',
            ],

            'password'      => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role'          => [
                'required',
                Rule::in([
                    'admin',
                    'reception',
                    'trainer',
                    'player',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | Staff
            |--------------------------------------------------------------------------
            */

            'salary_type'   => [
                Rule::requiredIf(
                    in_array($role, ['admin', 'reception', 'trainer'])
                ),
                Rule::in([
                    'fixed',
                    'percentage',
                ]),
            ],

            'base_salary'   => [
                Rule::requiredIf(
                    in_array($role, ['admin', 'reception', 'trainer'])
                ),
                'numeric',
                'min:0',
            ],

            /*
            |--------------------------------------------------------------------------
            | Player
            |--------------------------------------------------------------------------
            */

            'unique_number' => [
                Rule::requiredIf($role === 'player'),
                'string',
                'max:255',
                'unique:players,unique_number',
            ],

            'height'        => [
                'nullable',
                'numeric',
                'min:0',
                'max:300',
            ],

            'weight'        => [
                'nullable',
                'numeric',
                'min:0',
                'max:500',
            ],

            'health_status' => [
                'nullable',
                'string',
            ],

            'occupation'    => [
                'nullable',
                'string',
                'max:255',
            ],

            'gender'        => [
                Rule::requiredIf($role === 'player'),
                Rule::in([
                    'male',
                    'female',
                ]),
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
