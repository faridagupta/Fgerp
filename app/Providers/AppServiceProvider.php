<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
{
// 	$this->app->bind(\Illuminate\Contracts\Routing\UrlGenerator::class, function ($app) {
//       return new \Laravel\Lumen\Routing\UrlGenerator($app);
// });
     $this->app->singleton('Illuminate\Contracts\Routing\ResponseFactory', function ($app) {
        return new \Illuminate\Routing\ResponseFactory(
            $app['Illuminate\Contracts\View\Factory'],
            $app['Illuminate\Routing\Redirector']
        );
    });
}
}
