<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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

        $rules = [];

        if ($this->get('email') && $this->has('email')) {
            $rules['email'] = 'email|unique:users,email,'.$this->route('id');
        }

        if ($this->get('password') && $this->has('password')) {
            $rules['password'] = 'string|confirmed';
        }

        return $rules;

    }
}
