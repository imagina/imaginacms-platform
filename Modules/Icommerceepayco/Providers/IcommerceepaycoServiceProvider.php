<?php

namespace Modules\Icommerceepayco\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Arr;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
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
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommerceepaycoSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommerceepaycos', Arr::dot(trans('icommerceepayco::icommerceepaycos')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('icommerceepayco', 'permissions');
        $this->publishConfig('icommerceepayco', 'config');
        $this->publishConfig('icommerceepayco', 'crud-fields');

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
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
