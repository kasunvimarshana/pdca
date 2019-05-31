<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
//use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response;
use App\User;
use App\Login;
use App\UserRole;

class MemberMiddleware
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
        if( (!Login::isLogin()) ){
            return redirect('/login');
        }
        return $next($request);
    }
}
