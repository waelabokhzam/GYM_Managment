<?php

namespace App\Http\Requests\TrainerGameTimeSlot;

use App\Models\Game;
use App\Models\TimeSlot;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreTrainerGameTimeSlotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'staff_id' => [
                'required',
                'integer',
                'exists:staff,id',
            ],

            'game_id' => [
                'required',
                'integer',
                'exists:games,id',
            ],

            'time_slot_id' => [
                'required',
                'integer',
                'exists:time_slots,id',
            ],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $staff = \App\Models\Staff::find($this->staff_id);

                if ($staff && $staff->role !== 'trainer') {
                    $validator->errors()->add(
                        'staff_id',
                        'الموظف المحدد ليس مدربًا.'
                    );
                }

                $exists = \App\Models\TrainerGameTimeSlot::query()
                    ->where('staff_id', $this->staff_id)
                    ->where('game_id', $this->game_id)
                    ->where('time_slot_id', $this->time_slot_id)
                    ->exists();

                if ($exists) {
                    $validator->errors()->add(
                        'staff_id',
                        'هذا المدرب معين لهذه اللعبة في هذه الفترة مسبقًا.'
                    );
                }

                $gameBelongsToSlot = \App\Models\Game::query()
                    ->whereKey($this->game_id)
                    ->whereHas('timeSlots', function ($query) {
                        $query->whereKey($this->time_slot_id);
                    })
                    ->exists();

                if (!$gameBelongsToSlot) {
                    $validator->errors()->add(
                        'game_id',
                        'اللعبة المحددة غير مرتبطة بهذه الفترة التدريبية.'
                    );
                }
            },
        ];
    }
}