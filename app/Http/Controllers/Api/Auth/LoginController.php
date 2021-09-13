<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        //$user = User::find(1);

        $user = User::where('email', $login['email'])->first();

        if( !Auth::attempt( $login ) ) {

            return response(['message' => 'Invalid Login Credentials']);

        }

        $user_login_token= $user->createToken('UserToken')->accessToken;

        return response()->json(['user' => Auth::user(), 'token' => $user_login_token], 200);

    }
}
