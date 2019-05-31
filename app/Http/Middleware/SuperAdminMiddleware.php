<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
//use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response;
use App\User;
use App\Login;
use App\UserRole;

class SuperAdminMiddleware
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
        $loginUser = Login::getUserData();
        $loginUserRole = new UserRole();
        $hasRole = $loginUserRole->where('user_pk','=',$loginUser->mail)
            ->where('role_pk','=','super-admin')
            ->exists();
        if( !$hasRole ){
            return redirect()->back();
        }
        return $next($request);
    }
}
