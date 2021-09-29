<?php

namespace App\Http\Requests\Routine;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoutineRequest extends FormRequest
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
            'name' => 'required | max:255',
            'slug' => 'alpha_dash',
            'code' => 'required',
            'default_set' => 'required',
            'timer' => 'required',
            'rest_timer' => 'required',
            'video' => 'video | mimes:mp4,mov,ogg,flv | max:10240',
            'image' => 'image | mimes:jpg,bmp,png,jpeg | max:10240',
            'description' => 'max:5000',
        ];
    }
}
