<?php

namespace Modules\Ifillable\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Ifillable\Listeners\RegisterIfillableSidebar;

class IfillableServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIfillableSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });


    }

    public function boot()
    {
       
        $this->publishConfig('ifillable', 'config');
        $this->publishConfig('ifillable', 'crud-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('ifillable', 'settings'), "asgard.ifillable.settings");
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ifillable', 'settings-fields'), "asgard.ifillable.settings-fields");
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ifillable', 'permissions'), "asgard.ifillable.permissions");

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
            'Modules\Ifillable\Repositories\FieldRepository',
            function () {
                $repository = new \Modules\Ifillable\Repositories\Eloquent\EloquentFieldRepository(new \Modules\Ifillable\Entities\Field());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ifillable\Repositories\Cache\CacheFieldDecorator($repository);
            }
        );
// add bindings

    }


}
