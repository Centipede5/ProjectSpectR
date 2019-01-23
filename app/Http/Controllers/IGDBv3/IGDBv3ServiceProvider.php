<?php

namespace App\Http\Controllers\IGDBv3;

use Illuminate\Support\ServiceProvider;

class IGDBv3ServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('igdbv3', function () {
            return new IGDBv3(config('services.igdbv3.key'), config('services.igdbv3.url'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [IGDBv3::class];
    }
}
