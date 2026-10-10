<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'exists:users,id',
            ],

            'check_in' => [
                'required',
                'date',
            ],

            'check_out' => [
                'nullable',
                'date',
                'after_or_equal:check_in',
            ],

            'status' => [
                'required',
                Rule::in([
                    'open',
                    'completed',
                    'auto_closed',
                ]),
            ],

            'time_slot_id' => [
                'nullable',
                'exists:time_slots,id',
            ],

            'game_id' => [
                'nullable',
                'exists:games,id',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ];
    }
}