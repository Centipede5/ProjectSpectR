<?php

namespace App\Http\Controllers\PSNAPI;

use Illuminate\Support\ServiceProvider;

class PSNAPIServiceProvider extends ServiceProvider
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
        $this->app->bind('psnapi', function () {
            return new PSNAPI(config('services.psnapi.url'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [PSNAPI::class];
    }
}
