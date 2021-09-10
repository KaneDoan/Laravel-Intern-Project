<?php

namespace App\Http\Controller\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $token = $user->createToken('Access Token')->accessToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        // Check email
        $user = User::where('email', $data['email'])->first();

        if(!Auth::attempt($data)){
            return response(['message' => 'Invalid login credentials']);
        }

        $token = $user->createToken('Access Token')->accessToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 200);

    }
}
