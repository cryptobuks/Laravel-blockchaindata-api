<?php

namespace Waygood\BlockchainData;

use Illuminate\Support\ServiceProvider;

class BlockchainDataServiceProvider extends ServiceProvider
{
    /*
    * Indicates if loading of the provider is deferred.
    *
    * @var bool
    */
    protected $defer = false;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('laravel-blockchaindata', function() {
            return new BlockchainData;
        });
    }
    /**
    * Get the services provided by the provider
    * @return array
    */
    public function provides()
    {
        return ['laravel-blockchaindata'];
    }
}
