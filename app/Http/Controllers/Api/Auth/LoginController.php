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

        $user = User::where('email', $login['email'])->first();

        if( !Auth::attempt( $login ) ) {

            return response ( [ 'message' => 'Invalid Login Credentials' ] );

        }

        $accessToken = $user->createToken('authToken')->accessToken;

        return response ([ 'user' => Auth::user(), 'access_token' => $accessToken ], 200 );

    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return redirect('login') ->response()->json([
            'message' => 'successful-logout'
        ]);
    }
}
