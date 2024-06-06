<?php

namespace Modules\Ihelpers\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Ihelpers\Console\ClearPageCache;

use Modules\Core\Traits\CanPublishConfiguration;

class IhelpersServiceProvider extends ServiceProvider
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
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->registerCommands();
    }

    public function boot()
    {
        $this->publishConfig('ihelpers', 'config');
        $this->publishConfig('ihelpers', 'permissions');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
// add bindings
    }

    /**
     * Register all commands for this module
     */
    private function registerCommands()
    {
        $this->registerCacheClearCommand();
    }

    /**
     * Register the refresh thumbnails command
     */
    private function registerCacheClearCommand()
    {

        $this->app['command.ihelpers.pagecacheclear'] = $this->app->make(ClearPageCache::class);;
        $this->commands(['command.ihelpers.pagecacheclear']);
    }
}
