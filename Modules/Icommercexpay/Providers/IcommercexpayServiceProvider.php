<?php

namespace Modules\Icommercexpay\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Icommercexpay\Events\Handlers\RegisterIcommercexpaySidebar;

class IcommercexpayServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommercexpaySidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommercexpays', Arr::dot(trans('icommercexpay::icommercexpays')));
            // append translations
        });
    }

    public function boot(): void
    {
        $this->publishConfig('icommercexpay', 'permissions');
        $this->publishConfig('icommercexpay', 'config');
        $this->publishConfig('icommercexpay', 'crud-fields');

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
            'Modules\Icommercexpay\Repositories\IcommerceXpayRepository',
            function () {
                $repository = new \Modules\Icommercexpay\Repositories\Eloquent\EloquentIcommerceXpayRepository(new \Modules\Icommercexpay\Entities\IcommerceXpay());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommercexpay\Repositories\Cache\CacheIcommerceXpayDecorator($repository);
            }
        );
        // add bindings
    }
}
