<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\HelperClasses\StullerAPIControllerHelper;

class HelperClassServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Http\HelperClasses\\StullerAPIControllerHelper', function ($app) {
            return new StullerAPIControllerHelper();
          });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
