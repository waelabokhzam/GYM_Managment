<?php

namespace App\Http\Requests\PlayerGame;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlayerGameRequest extends FormRequest
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

            'player_id' => [
                'required',
                'exists:players,id',
            ],

            'game_id' => [
                'required',
                'exists:games,id',
                Rule::unique('player_games')
                    ->where(fn ($query) => $query->where(
                        'player_id',
                        $this->player_id
                    )),
            ],

        ];
    }

    public function messages(): array
    {
        return [
            'game_id.unique' => 'هذا اللاعب مسجل في هذه اللعبة مسبقًا.',
        ];
    }
}
