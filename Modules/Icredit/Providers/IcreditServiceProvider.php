<?php

namespace Modules\Icredit\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Icredit\Listeners\RegisterIcreditSidebar;

class IcreditServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcreditSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('credits', Arr::dot(trans('icredit::credits')));
            // append translations

        });


    }

    public function boot()
    {
        $this->publishConfig('icredit', 'config');
        $this->publishConfig('icredit', 'crud-fields');

      $this->mergeConfigFrom($this->getModuleConfigFilePath('icredit', 'settings'), "asgard.icredit.settings");
      $this->mergeConfigFrom($this->getModuleConfigFilePath('icredit', 'settings-fields'), "asgard.icredit.settings-fields");
      $this->mergeConfigFrom($this->getModuleConfigFilePath('icredit', 'permissions'), "asgard.icredit.permissions");
      $this->mergeConfigFrom($this->getModuleConfigFilePath('icredit', 'cmsPages'), "asgard.icredit.cmsPages");
      $this->mergeConfigFrom($this->getModuleConfigFilePath('icredit', 'cmsSidebar'), "asgard.icredit.cmsSidebar");

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
            'Modules\Icredit\Repositories\CreditRepository',
            function () {
                $repository = new \Modules\Icredit\Repositories\Eloquent\EloquentCreditRepository(new \Modules\Icredit\Entities\Credit());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icredit\Repositories\Cache\CacheCreditDecorator($repository);
            }
        );
// add bindings

    }


}
