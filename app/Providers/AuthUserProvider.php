<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use App\User;
use App\Login;
use App\UserRole;

class AuthUserProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer('*', function($view){
            $user = Login::getUserData();
            $view->with('auth_user', $user);
        });
        
        Blade::if('superadmin', function(){
            $role = 'super-admin';
            $loginUser = Login::getUserData();
            $loginUserRole = new UserRole();
            $hasRole = $loginUserRole->where('user_pk','=',$loginUser->mail)
                ->where('role_pk','=',$role)
                ->exists();
            $hasRole = ($hasRole) ? true : false;
            return $hasRole;
        });
    }
}
