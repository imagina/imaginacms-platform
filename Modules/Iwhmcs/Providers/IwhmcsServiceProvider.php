<?php

namespace Modules\Iwhmcs\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Iwhmcs\Listeners\RegisterIwhmcsSidebar;

class IwhmcsServiceProvider extends ServiceProvider
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
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIwhmcsSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });
    }

    public function boot()
    {
        $this->publishConfig('iwhmcs', 'permissions');

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        //Instance WHMCS DB connection
        \Config::set('database.connections.whmcs', [
            'driver' => env('B24_WHCMS_DB_CONNECTION', 'mysql'),
            'host' => env('B24_WHCMS_DB_HOST', '127.0.0.1'),
            'port' => env('B24_WHCMS_DB_PORT', '3306'),
            'database' => env('B24_WHCMS_DB_DATABASE', 'forge'),
            'username' => env('B24_WHCMS_DB_USERNAME', 'forge'),
            'password' => env('B24_WHCMS_DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ]);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides()
    {
        return [];
    }

    private function registerBindings()
    {
        // add bindings
    }
}
