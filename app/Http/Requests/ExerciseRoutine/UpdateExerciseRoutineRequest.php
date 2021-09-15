<?php

namespace App\Http\Requests\ExerciseRoutine;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExerciseRoutineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sort_id' => 'required',
            'display_id' => 'required',
            'default_reps' => 'required',
        ];
    }
}
