<?php

namespace Modules\Iredirect\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Iredirect\Entities\Redirect;
use Modules\Iredirect\Repositories\Cache\CacheRedirectDecorator;
use Modules\Iredirect\Repositories\Eloquent\EloquentRedirectRepository;
use Modules\Iredirect\Repositories\RedirectRepository;

class IredirectServiceProvider extends ServiceProvider
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
        $this->publishConfig('iredirect', 'config');
        //$this->publishConfig('iredirect', 'settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iredirect', 'permissions'), 'asgard.iredirect.permissions');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iredirect', 'cmsPages'), 'asgard.iredirect.cmsPages');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iredirect', 'cmsSidebar'), 'asgard.iredirect.cmsSidebar');
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
        $this->app->bind(RedirectRepository::class, function () {
            $repository = new EloquentRedirectRepository(new Redirect());

            if (config('app.cache') === false) {
                return $repository;
            }

            return new CacheRedirectDecorator($repository);
        });
    }
}
