<?php

namespace Modules\Requestable\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Requestable\Events\Handlers\RegisterRequestableSidebar;

class RequestableServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterRequestableSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('requestables', Arr::dot(trans('requestable::requestables')));
            // append translations
        });
    }

    public function boot()
    {
        $this->mergeConfigFrom($this->getModuleConfigFilePath('requestable', 'permissions'), 'asgard.requestable.permissions');
        $this->publishConfig('requestable', 'config');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('requestable', 'settings'), 'asgard.requestable.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('requestable', 'settings-fields'), 'asgard.requestable.settings-fields');
        //$this->publishConfig('requestable', 'requests');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('requestable', 'cmsPages'), 'asgard.requestable.cmsPages');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('requestable', 'cmsSidebar'), 'asgard.requestable.cmsSidebar');

        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
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
            'Modules\Requestable\Repositories\RequestableRepository',
            function () {
                $repository = new \Modules\Requestable\Repositories\Eloquent\EloquentRequestableRepository(new \Modules\Requestable\Entities\Requestable());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Requestable\Repositories\Cache\CacheRequestableDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Requestable\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Requestable\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Requestable\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Requestable\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Requestable\Repositories\StatusRepository',
            function () {
                $repository = new \Modules\Requestable\Repositories\Eloquent\EloquentStatusRepository(new \Modules\Requestable\Entities\Status());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Requestable\Repositories\Cache\CacheStatusDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Requestable\Repositories\FieldRepository',
            function () {
                $repository = new \Modules\Requestable\Repositories\Eloquent\EloquentFieldRepository(new \Modules\Requestable\Entities\Field());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Requestable\Repositories\Cache\CacheFieldDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Requestable\Repositories\StatusHistoryRepository',
            function () {
                $repository = new \Modules\Requestable\Repositories\Eloquent\EloquentStatusHistoryRepository(new \Modules\Requestable\Entities\StatusHistory());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Requestable\Repositories\Cache\CacheStatusHistoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Requestable\Repositories\CategoryRuleRepository',
            function () {
                $repository = new \Modules\Requestable\Repositories\Eloquent\EloquentCategoryRuleRepository(new \Modules\Requestable\Entities\CategoryRule());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Requestable\Repositories\Cache\CacheCategoryRuleDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Requestable\Repositories\AutomationRuleRepository',
            function () {
                $repository = new \Modules\Requestable\Repositories\Eloquent\EloquentAutomationRuleRepository(new \Modules\Requestable\Entities\AutomationRule());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Requestable\Repositories\Cache\CacheAutomationRuleDecorator($repository);
            }
        );
        // add bindings
    }
}
