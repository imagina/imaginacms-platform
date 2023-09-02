<?php

namespace Modules\Icommercepricelist\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;

class IcommercepricelistServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;

    /**
     * Boot the application events.
     */
    public function boot()
    {
        $this->registerConfig();
        $this->registerViews();
        //$this->loadMigrationsFrom(module_path('Icommercepricelist', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerBindings();
        $this->registerTranslations();
    }

    /**
     * Register config.
     */
    protected function registerConfig()
    {
        $this->publishConfig('icommercepricelist', 'config');
        $this->publishConfig('icommercepricelist', 'crud-fields');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('icommercepricelist', 'permissions'), 'asgard.icommercepricelist.permissions');
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Icommercepricelist\Repositories\PriceListRepository',
            function () {
                $repository = new \Modules\Icommercepricelist\Repositories\Eloquent\EloquentPriceListRepository(new \Modules\Icommercepricelist\Entities\PriceList());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommercepricelist\Repositories\Cache\CachePriceListDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommercepricelist\Repositories\ProductListRepository',
            function () {
                $repository = new \Modules\Icommercepricelist\Repositories\Eloquent\EloquentProductListRepository(new \Modules\Icommercepricelist\Entities\ProductList());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommercepricelist\Repositories\Cache\CacheProductListDecorator($repository);
            }
        );
    }

    /**
     * Register views.
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/icommercepricelist');

        $sourcePath = module_path('Icommercepricelist', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path.'/modules/icommercepricelist';
        }, \Config::get('view.paths')), [$sourcePath]), 'icommercepricelist');
    }

    /**
     * Register translations.
     */
    public function registerTranslations()
    {
        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('pricelists', Arr::dot(trans('icommercepricelist::pricelists')));
            $event->load('routes', Arr::dot(trans('icommercepricelist::routes')));
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides()
    {
        return [];
    }
}
