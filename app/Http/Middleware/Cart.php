<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class Cart
{
    public function handle($request, Closure $next)
    {
        if(Auth::guard('Member')->check())
        {
            return $next($request);
        }
        return redirect('login');
    }
}
