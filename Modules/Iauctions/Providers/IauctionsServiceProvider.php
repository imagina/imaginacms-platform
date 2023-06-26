<?php

namespace Modules\Iauctions\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Iauctions\Listeners\RegisterIauctionsSidebar;

class IauctionsServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIauctionsSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });
    }

    public function boot(): void
    {
        $this->publishConfig('iauctions', 'config');
        $this->publishConfig('iauctions', 'crud-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('iauctions', 'settings'), 'asgard.iauctions.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iauctions', 'settings-fields'), 'asgard.iauctions.settings-fields');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iauctions', 'permissions'), 'asgard.iauctions.permissions');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iauctions', 'cmsPages'), 'asgard.iauctions.cmsPages');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iauctions', 'cmsSidebar'), 'asgard.iauctions.cmsSidebar');

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
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
            'Modules\Iauctions\Repositories\AuctionRepository',
            function () {
                $repository = new \Modules\Iauctions\Repositories\Eloquent\EloquentAuctionRepository(new \Modules\Iauctions\Entities\Auction());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iauctions\Repositories\Cache\CacheAuctionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iauctions\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Iauctions\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Iauctions\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iauctions\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iauctions\Repositories\BidRepository',
            function () {
                $repository = new \Modules\Iauctions\Repositories\Eloquent\EloquentBidRepository(new \Modules\Iauctions\Entities\Bid());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iauctions\Repositories\Cache\CacheBidDecorator($repository);
            }
        );
        // add bindings
    }
}
