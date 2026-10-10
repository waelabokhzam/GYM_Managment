<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttendanceRequest extends FormRequest
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
                'integer',
                'exists:users,id',
            ],

            'check_in' => [
                'nullable',
                'date',
            ],

            'time_slot_id' => [
                'nullable',
                'integer',
                'exists:time_slots,id',
            ],

            'game_id' => [
                'nullable',
                'integer',
                'exists:games,id',
            ],

            'device' => [
                'nullable',
                'string',
                'max:100',
            ],

            'fingerprint_id' => [
                'nullable',
                'string',
                'max:100',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ];
    }
}