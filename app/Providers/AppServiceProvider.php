<?php

namespace App\Providers;

use App\Http\Controllers\StullerAPIController;
use App\Models\ShopOwner;
use App\Observers\ShopOwnerObserver;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ShopOwner::observe(ShopOwnerObserver::class);
    }
}
