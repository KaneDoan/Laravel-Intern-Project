<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check()){
            //return redirect()->route('home');
            return("Go home");
        }

        if(Auth::user()->is_admin == 1){
            return $next($request);
        }

        return redirect()->back()->withFlashDanger(__('You do not have access to do that.'));
    }
}
