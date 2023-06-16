<?php

namespace Modules\Idocs\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Idocs\Events\Handlers\RegisterIdocsSidebar;

class IdocsServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIdocsSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('categories', Arr::dot(trans('idocs::categories')));
            $event->load('documents', Arr::dot(trans('idocs::documents')));
            // append translations
        });
    }

    public function boot()
    {
        $this->mergeConfigFrom($this->getModuleConfigFilePath('idocs', 'permissions'), 'asgard.idocs.permissions');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('idocs', 'cmsPages'), 'asgard.idocs.cmsPages');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('idocs', 'cmsSidebar'), 'asgard.idocs.cmsSidebar');
        $this->publishConfig('idocs', 'config');
        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

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
            'Modules\Idocs\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Idocs\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Idocs\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Idocs\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Idocs\Repositories\DocumentRepository',
            function () {
                $repository = new \Modules\Idocs\Repositories\Eloquent\EloquentDocumentRepository(new \Modules\Idocs\Entities\Document());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Idocs\Repositories\Cache\CacheDocumentDecorator($repository);
            }
        );
        // add bindings
    }

    /**
     * Register Blade components
     */
    private function registerComponents()
    {
        Blade::componentNamespace("Modules\Idocs\View\Components", 'idocs');
    }
}
