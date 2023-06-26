<?php

namespace Modules\Iforms\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Iforms\Events\Handlers\RegisterIformsSidebar;

class IformsServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIformsSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('forms', Arr::dot(trans('iforms::forms')));
            $event->load('fields', Arr::dot(trans('iforms::fields')));
            $event->load('leads', Arr::dot(trans('iforms::leads')));
        });
    }

    public function boot(): void
    {
        $this->publishConfig('iforms', 'config');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iforms', 'settings'), 'asgard.iforms.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iforms', 'settings-fields'), 'asgard.iforms.settings-fields');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iforms', 'permissions'), 'asgard.iforms.permissions');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iforms', 'cmsPages'), 'asgard.iforms.cmsPages');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iforms', 'cmsSidebar'), 'asgard.iforms.cmsSidebar');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iforms', 'blocks'), 'asgard.iforms.blocks');
        $this->publishConfig('iforms', 'crud-fields');
        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->registerComponents();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['Iforms'];
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Iforms\Repositories\FormRepository',
            function () {
                $repository = new \Modules\Iforms\Repositories\Eloquent\EloquentFormRepository(new \Modules\Iforms\Entities\Form());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iforms\Repositories\Cache\CacheFormDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iforms\Repositories\FieldRepository',
            function () {
                $repository = new \Modules\Iforms\Repositories\Eloquent\EloquentFieldRepository(new \Modules\Iforms\Entities\Field());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iforms\Repositories\Cache\CacheFieldDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iforms\Repositories\LeadRepository',
            function () {
                $repository = new \Modules\Iforms\Repositories\Eloquent\EloquentLeadRepository(new \Modules\Iforms\Entities\Lead());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iforms\Repositories\Cache\CacheLeadDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iforms\Repositories\BlockRepository',
            function () {
                $repository = new \Modules\Iforms\Repositories\Eloquent\EloquentBlockRepository(new \Modules\Iforms\Entities\Block());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iforms\Repositories\Cache\CacheBlockDecorator($repository);
            }
        );
        // add bindings

        $this->app->bind('Modules\Iforms\Presenters\FormPresenter');
    }

    /**
     * Register Blade components
     */
    private function registerComponents()
    {
        Blade::componentNamespace("Modules\Iforms\View\Components", 'iforms');
    }
}
