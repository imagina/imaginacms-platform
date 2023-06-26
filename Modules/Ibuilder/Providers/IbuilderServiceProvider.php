<?php

namespace Modules\Ibuilder\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Ibuilder\Listeners\RegisterIbuilderSidebar;

class IbuilderServiceProvider extends ServiceProvider
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
    public function register(): void
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIbuilderSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });
    }

    public function boot(): void
    {
        $this->publishConfig('ibuilder', 'config');
        $this->publishConfig('ibuilder', 'crud-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('ibuilder', 'settings'), 'asgard.ibuilder.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ibuilder', 'settings-fields'), 'asgard.ibuilder.settings-fields');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ibuilder', 'permissions'), 'asgard.ibuilder.permissions');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ibuilder', 'cmsPages'), 'asgard.ibuilder.cmsPages');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ibuilder', 'cmsSidebar'), 'asgard.ibuilder.cmsSidebar');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ibuilder', 'blocks'), 'asgard.ibuilder.blocks');

        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->registerComponents();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Ibuilder\Repositories\BlockRepository',
            function () {
                $repository = new \Modules\Ibuilder\Repositories\Eloquent\EloquentBlockRepository(new \Modules\Ibuilder\Entities\Block());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ibuilder\Repositories\Cache\CacheBlockDecorator($repository);
            }
        );
        // add bindings
    }

    /**
     * Register Blade components
     */
    private function registerComponents()
    {
        Blade::componentNamespace("Modules\Ibuilder\View\Components", 'ibuilder');
    }
}
