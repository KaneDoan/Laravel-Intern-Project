<?php

namespace App\Http\Requests\Gym;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreGymRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return Auth::user()->is_admin;
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
            'name' => 'required|max:255',
            'slug' => 'alpha_dash',
            'pin' => 'required',
            'no_of_displays' => 'required',
            'description' => 'max:5000',
            //'thumbnail' =>  ['file'],
        ];
    }
}
