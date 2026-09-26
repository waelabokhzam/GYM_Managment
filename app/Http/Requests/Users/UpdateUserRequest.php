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
            /*
            |--------------------------------------------------------------------------
            | User
            |--------------------------------------------------------------------------
            */

            'fullname' => [
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
                Rule::unique('users', 'phone')->ignore($user?->id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
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

            'salary_type' => [
                Rule::requiredIf(
                    in_array($role, ['admin', 'reception', 'trainer'])
                ),
                Rule::in([
                    'fixed',
                    'percentage',
                ]),
            ],

            'base_salary' => [
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
                Rule::unique('players', 'unique_number')
                    ->ignore($user?->player?->id),
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

            'health_status' => [
                'nullable',
                'string',
            ],

            'occupation' => [
                'nullable',
                'string',
                'max:255',
            ],

            'gender' => [
                Rule::requiredIf($role === 'player'),
                Rule::in([
                    'male',
                    'female',
                ]),
            ],
        ];
    }
}
