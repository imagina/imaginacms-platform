<?php

namespace Modules\Icustom\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;

class IcustomServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerBindings();
    }

    public function boot()
    {
        $this->publishConfig('icustom', 'permissions');
        $this->publishConfig('icustom', 'config');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides()
    {
        return [];
    }

    private function registerBindings()
    {
        // add bindings
    }
}
