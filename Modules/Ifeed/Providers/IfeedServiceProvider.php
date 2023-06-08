<?php

namespace Modules\Ifeed\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Ifeed\Listeners\RegisterIfeedSidebar;

class IfeedServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIfeedSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });


    }

    public function boot()
    {
       
        $this->publishConfig('ifeed', 'config');
        $this->publishConfig('ifeed', 'crud-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('ifeed', 'settings'), "asgard.ifeed.settings");
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ifeed', 'settings-fields'), "asgard.ifeed.settings-fields");
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ifeed', 'permissions'), "asgard.ifeed.permissions");

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
            'Modules\Ifeed\Repositories\FeedRepository',
            function () {
                $repository = new \Modules\Ifeed\Repositories\Eloquent\EloquentFeedRepository(new \Modules\Ifeed\Entities\Feed());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ifeed\Repositories\Cache\CacheFeedDecorator($repository);
            }
        );
// add bindings

    }


}
