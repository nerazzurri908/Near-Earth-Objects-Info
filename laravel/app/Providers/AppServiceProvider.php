<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Common\NasaAsteroidsApi\INasaAsteroidsApi;
use App\Common\NasaAsteroidsApi\NasaAsteroidsApi;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(INasaAsteroidsApi::class, function ($app) {
            return new NasaAsteroidsApi();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
