<?php

namespace App\Http\Controllers\XBOXAPI;

use Illuminate\Support\ServiceProvider;

class XBOXAPIServiceProvider extends ServiceProvider
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
        $this->app->bind('xboxapi', function () {
            return new XBOXAPI(config('services.xboxapi.url'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [XBOXAPI::class];
    }
}
