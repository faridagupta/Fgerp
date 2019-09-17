<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Dusterio\LumenPassport\LumenPassport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.
        //LumenPassport::routes($this->app);
        // LumenPassport::routes();
        
        $this->app['auth']->viaRequest('api', function ($request) {
             //$request->input('api_token'); exit;
             if ($request->header('Authorization')) {
                
                return User::where('api_token', $request->header('Authorization'))->first();
            }
        });
    }
}
