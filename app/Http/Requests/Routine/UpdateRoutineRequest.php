<?php

namespace App\Http\Requests\Routine;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoutineRequest extends FormRequest
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
            'video_path_url' => 'video | mimes:mp4,mov,ogg,flv | max:10240',
            'thumbnail_path_url' => 'image | mimes:jpg,bmp,png,jpeg | max:10240',
        ];
    }
}
