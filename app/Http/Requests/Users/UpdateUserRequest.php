<?php

namespace App\Http\Requests\Users;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $user = $this->route('user');
        $role = $this->input('role', $user->getRoleNames()->first());

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
            'unique:users,phone,' . $this->user->id,
        ],

        'role' => [
            'required',
            'string',
            'exists:roles,name',
        ],

        'password' => [
            'nullable',
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
}
