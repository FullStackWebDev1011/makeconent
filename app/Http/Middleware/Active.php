<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Active
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            if(Auth::user()->getStatus() !== 'active') {
                Auth::logout();
                return redirect('login')->withErrors(['account'=>'Your account is in review, please wait or contact.']);
            }
        }
        return $next($request);
    }
}
