<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]
        );

        if($validator->fails()){
            return response()->json(["validattion_errors"=>$validator->errors()]);
        }

        $data = array(

            "full_name"=>$request->full_name,
            "email"=>$request->email,
            "password"=>bcrypt($request->password),

        );

        $user = User::create($data);

        $token = $user->createToken('UserToken')->accessToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        //return response($response, 200);

        return response($response, 200);

    }
}
