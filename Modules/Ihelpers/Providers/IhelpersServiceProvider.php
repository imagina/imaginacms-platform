<?php

namespace Modules\Ihelpers\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Ihelpers\Console\ClearPageCache;

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
     */
    public function register(): void
    {
        $this->registerBindings();
        $this->registerCommands();
    }

    public function boot(): void
    {
        $this->publishConfig('ihelpers', 'config');
        $this->publishConfig('ihelpers', 'permissions');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
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
        $this->app['command.ihelpers.pagecacheclear'] = $this->app->make(ClearPageCache::class);
        $this->commands(['command.ihelpers.pagecacheclear']);
    }
}
