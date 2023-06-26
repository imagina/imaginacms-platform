<?php

namespace Modules\Icommerceepayco\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Icommerceepayco\Events\Handlers\RegisterIcommerceepaycoSidebar;

class IcommerceepaycoServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommerceepaycoSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommerceepaycos', Arr::dot(trans('icommerceepayco::icommerceepaycos')));
            // append translations
        });
    }

    public function boot(): void
    {
        $this->publishConfig('icommerceepayco', 'permissions');
        $this->publishConfig('icommerceepayco', 'config');
        $this->publishConfig('icommerceepayco', 'crud-fields');

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
            'Modules\Icommerceepayco\Repositories\IcommerceEpaycoRepository',
            function () {
                $repository = new \Modules\Icommerceepayco\Repositories\Eloquent\EloquentIcommerceEpaycoRepository(new \Modules\Icommerceepayco\Entities\IcommerceEpayco());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerceepayco\Repositories\Cache\CacheIcommerceEpaycoDecorator($repository);
            }
        );
        // add bindings
    }
}
