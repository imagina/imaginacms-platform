<?php

namespace Modules\Iplan\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Iplan\Events\Handlers\RegisterIplanidebar;

class IplanServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIplanidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('categories', array_dot(trans('iplan::categories')));
            $event->load('plans', array_dot(trans('iplan::plans')));
            $event->load('limits', array_dot(trans('iplan::limits')));
            $event->load('subscriptions', array_dot(trans('iplan::subscriptions')));
            $event->load('subscriptionlimits', array_dot(trans('iplan::subscriptionlimits')));
            // append translations
        });
    }

    public function boot(): void
    {
        $this->publishConfig('iplan', 'config');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('iplan', 'settings'), 'asgard.iplan.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iplan', 'settings-fields'), 'asgard.iplan.settings-fields');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iplan', 'permissions'), 'asgard.iplan.permissions');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iplan', 'cmsPages'), 'asgard.iplan.cmsPages');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iplan', 'cmsSidebar'), 'asgard.iplan.cmsSidebar');

        $this->publishConfig('iplan', 'crud-fields');

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->registerComponents();
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
        $this->app->bind(
            'Modules\Iplan\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Iplan\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Iplan\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplan\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iplan\Repositories\PlanRepository',
            function () {
                $repository = new \Modules\Iplan\Repositories\Eloquent\EloquentPlanRepository(new \Modules\Iplan\Entities\Plan());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplan\Repositories\Cache\CachePlanDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iplan\Repositories\LimitRepository',
            function () {
                $repository = new \Modules\Iplan\Repositories\Eloquent\EloquentLimitRepository(new \Modules\Iplan\Entities\Limit());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplan\Repositories\Cache\CacheLimitDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iplan\Repositories\SubscriptionRepository',
            function () {
                $repository = new \Modules\Iplan\Repositories\Eloquent\EloquentSubscriptionRepository(new \Modules\Iplan\Entities\Subscription());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplan\Repositories\Cache\CacheSubscriptionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iplan\Repositories\SubscriptionLimitRepository',
            function () {
                $repository = new \Modules\Iplan\Repositories\Eloquent\EloquentSubscriptionLimitRepository(new \Modules\Iplan\Entities\SubscriptionLimit());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplan\Repositories\Cache\CacheSubscriptionLimitDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iplan\Repositories\EntityPlanRepository',
            function () {
                $repository = new \Modules\Iplan\Repositories\Eloquent\EloquentEntityPlanRepository(new \Modules\Iplan\Entities\EntityPlan());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplan\Repositories\Cache\CacheEntityPlanDecorator($repository);
            }
        );
        // add bindings
    }

    /**
     * Register Blade components
     */
    private function registerComponents()
    {
        Blade::componentNamespace("Modules\Iplan\View\Components", 'iplan');
    }
}
