<?php

namespace Modules\Igamification\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Igamification\Listeners\RegisterIgamificationSidebar;

class IgamificationServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIgamificationSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });
    }

    public function boot(): void
    {
        $this->publishConfig('igamification', 'config');
        $this->publishConfig('igamification', 'crud-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('igamification', 'settings'), 'asgard.igamification.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('igamification', 'settings-fields'), 'asgard.igamification.settings-fields');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('igamification', 'permissions'), 'asgard.igamification.permissions');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('igamification', 'cmsPages'), 'asgard.igamification.cmsPages');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('igamification', 'cmsSidebar'), 'asgard.igamification.cmsSidebar');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('igamification', 'gamification'), 'asgard.igamification.gamification');

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [];
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Igamification\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Igamification\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Igamification\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Igamification\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Igamification\Repositories\ActivityRepository',
            function () {
                $repository = new \Modules\Igamification\Repositories\Eloquent\EloquentActivityRepository(new \Modules\Igamification\Entities\Activity());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Igamification\Repositories\Cache\CacheActivityDecorator($repository);
            }
        );
        // add bindings
    }
}
