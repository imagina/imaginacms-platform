<?php

namespace Modules\Wishlistable\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Wishlistable\Listeners\RegisterWishlistableSidebar;

class WishlistableServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterWishlistableSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('wishlistables', Arr::dot(trans('wishlistable::wishlistables')));
            // append translations
        });
    }

    public function boot(): void
    {
        $this->publishConfig('wishlistable', 'permissions');
        $this->publishConfig('wishlistable', 'config');

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->registerComponentsLivewire();
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
            'Modules\Wishlistable\Repositories\WishlistableRepository',
            function () {
                $repository = new \Modules\Wishlistable\Repositories\Eloquent\EloquentWishlistableRepository(new \Modules\Wishlistable\Entities\Wishlistable());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Wishlistable\Repositories\Cache\CacheWishlistableDecorator($repository);
            }
        );
        // add bindings
    }

  /**
   * Register components Livewire
   */
  private function registerComponentsLivewire()
  {
      Livewire::component('wishlistable::wishlist', \Modules\Wishlistable\Http\Livewire\Wishlist::class);
      Livewire::component('wishlistable::wishlistable', \Modules\Wishlistable\Http\Livewire\WishlistTable::class);
  }
}
