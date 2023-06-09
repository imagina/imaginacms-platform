<?php

namespace Modules\Icommercecredibanco\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Icommercecredibanco\Console\CheckUpdateOrders;
use Modules\Icommercecredibanco\Events\Handlers\RegisterIcommercecredibancoSidebar;

class IcommercecredibancoServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommercecredibancoSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommercecredibancos', Arr::dot(trans('icommercecredibanco::icommercecredibancos')));
            $event->load('transactions', Arr::dot(trans('icommercecredibanco::transactions')));
            // append translations
        });

        $this->registerCommands();
    }

    public function boot(): void
    {
        $this->publishConfig('icommercecredibanco', 'permissions');
        $this->publishConfig('icommercecredibanco', 'config');
        $this->publishConfig('icommercecredibanco', 'crud-fields');

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
            'Modules\Icommercecredibanco\Repositories\IcommerceCredibancoRepository',
            function () {
                $repository = new \Modules\Icommercecredibanco\Repositories\Eloquent\EloquentIcommerceCredibancoRepository(new \Modules\Icommercecredibanco\Entities\IcommerceCredibanco());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommercecredibanco\Repositories\Cache\CacheIcommerceCredibancoDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommercecredibanco\Repositories\TransactionRepository',
            function () {
                $repository = new \Modules\Icommercecredibanco\Repositories\Eloquent\EloquentTransactionRepository(new \Modules\Icommercecredibanco\Entities\Transaction());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommercecredibanco\Repositories\Cache\CacheTransactionDecorator($repository);
            }
        );
        // add bindings
    }

    /**
     * Register all commands for this module
     */
    private function registerCommands()
    {
        $this->registerIcommercecredibancoCommand();
    }

    /**
     * Register the refresh thumbnails command
     */
    private function registerIcommercecredibancoCommand()
    {
        $this->app['command.icommercecredibanco.updateorders'] = $this->app->make(CheckUpdateOrders::class);
        $this->commands(['command.icommercecredibanco.updateorders']);
    }
}
