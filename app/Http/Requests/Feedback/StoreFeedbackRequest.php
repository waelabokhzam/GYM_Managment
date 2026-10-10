<?php

namespace App\Http\Requests\Feedback;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'يرجى كتابة موضوع الملاحظة.',
            'message.required' => 'يرجى كتابة تفاصيل الملاحظة.',
        ];
    }
}
