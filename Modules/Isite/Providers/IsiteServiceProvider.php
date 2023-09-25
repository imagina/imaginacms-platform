<?php

namespace Modules\Isite\Providers;

use Anhskohbo\NoCaptcha\NoCaptcha;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;

use Modules\Isite\Console\GenerateSitemapCommand;
use Modules\Isite\Console\TenantModuleMigrateCommand;
use Modules\Isite\Console\TenantsScheduleCommand;
use Modules\Isite\Console\TenantAiCommand;

use Modules\Isite\Events\Handlers\RegisterIsiteSidebar;
use Modules\Isite\Http\Middleware\CaptchaMiddleware;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Modules\Isite\Http\Middleware\InitializeOrganizationByRequestDataMiddleware;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Modules\Isite\View\Components\Multilang;
use Modules\Isite\View\Components\Categorylist;

use Modules\Isite\Http\Middleware\CheckIp;

class IsiteServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $middleware = [
        'captcha' => CaptchaMiddleware::class,
        'checkIp' => CheckIp::class,
    ];

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerBindings();
        $this->registerCommands();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIsiteSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('sites', Arr::dot(trans('isite::sites')));
            $event->load('recommendations', Arr::dot(trans('isite::recommendations')));
            // append translations
        });

        $this->app->singleton('icaptcha', function ($app) {
            return new NoCaptcha(
                setting('isite::reCaptchaV2Secret') ?? setting('isite::reCaptchaV3Secret'),
                setting('isite::reCaptchaV2Site') ?? setting('isite::reCaptchaV3Site'),
                $app['config']['captcha.options']
            );
        });

        BelongsToTenant::$tenantIdColumn = 'organization_id';

        /*
        * JOB EVENTS
        */
        $this->app['events']->listen(\Illuminate\Queue\Events\JobProcessing::class, function ($event) {
            //Checking jobs without tenant_id
            if (! is_null($event->job->payload()) && ! isset($event->job->payload()['tenant_id'])) {
                $dbName = \DB::connection()->getDatabaseName();
                //\Log::info("ENV DATABASE: ".env("DB_DATABASE")." | Connection: ".$dbName);

                //Only if is not the same current connection
                if ($dbName != env('DB_DATABASE')) {
                    \Config::set('database.default', 'mysql');
                }
            }
        });

        //Not include all cases when create a tenant
        /*
        $this->app['events']->listen(\Illuminate\Queue\Events\JobProcessed ::class, function ($event) {
          //Only with tenant
          if( !is_null($event->job->payload()) && isset($event->job->payload()['tenant_id'])) {
            \Config::set('database.default', 'mysql');
            \DB::disconnect('newConnectionTenant');
          }
        });
        */
    }

    public function boot()
    {
        $this->registerMiddleware();
        $this->publishConfig('isite', 'config');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('isite', 'settings'), 'asgard.isite.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('isite', 'settings-fields'), 'asgard.isite.settings-fields');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('isite', 'permissions'), 'asgard.isite.permissions');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('isite', 'deprecated-settings'), 'asgard.isite.deprecated-settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('isite', 'cmsPages'), 'asgard.isite.cmsPages');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('isite', 'cmsSidebar'), 'asgard.isite.cmsSidebar');
        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('isite', 'standardValuesForBlocksAttributes'), 'asgard.isite.standardValuesForBlocksAttributes');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('isite', 'blocks'), 'asgard.isite.blocks');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('isite', 'gamification'), 'asgard.isite.gamification');

        $app = $this->app;

        $this->app['validator']->extend('icaptcha', function ($attribute, $value) use ($app) {
            return $app['icaptcha']->verifyResponse($value, $app['request']->getClientIp());
        });

        $this->registerComponents();
        $this->registerComponentsLivewire();
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
        $this->app->bind(
            'Modules\Isite\Repositories\RecommendationRepository',
            function () {
                $repository = new \Modules\Isite\Repositories\Eloquent\EloquentRecommendationRepository(new \Modules\Isite\Entities\Recommendation());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Isite\Repositories\Cache\CacheRecommendationDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Isite\Repositories\OrganizationRepository',
            function () {
                $repository = new \Modules\Isite\Repositories\Eloquent\EloquentOrganizationRepository(new \Modules\Isite\Entities\Organization());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Isite\Repositories\Cache\CacheOrganizationDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Isite\Repositories\OrganizationFieldRepository',
            function () {
                $repository = new \Modules\Isite\Repositories\Eloquent\EloquentOrganizationFieldRepository(new \Modules\Isite\Entities\OrganizationField());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Isite\Repositories\Cache\CacheOrganizationFieldDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Isite\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Isite\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Isite\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Isite\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Isite\Repositories\IcrudRepository',
            function () {
                $repository = new \Modules\Isite\Repositories\Eloquent\EloquentIcrudRepository(new \Modules\Isite\Entities\Icrud());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Isite\Repositories\Cache\CacheIcrudDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Isite\Repositories\DomainRepository',
            function () {
                $repository = new \Modules\Isite\Repositories\Eloquent\EloquentDomainRepository(new \Modules\Isite\Entities\Domain());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Isite\Repositories\Cache\CacheDomainDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Isite\Repositories\LayoutRepository',
            function () {
                $repository = new \Modules\Isite\Repositories\Eloquent\EloquentLayoutRepository(new \Modules\Isite\Entities\Layout());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Isite\Repositories\Cache\CacheLayoutDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Isite\Repositories\TypeableRepository',
            function () {
                $repository = new \Modules\Isite\Repositories\Eloquent\EloquentTypeableRepository(new \Modules\Isite\Entities\Typeable());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Isite\Repositories\Cache\CacheTypeableDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Isite\Repositories\ModuleRepository',
            function () {
                $repository = new \Modules\Isite\Repositories\Eloquent\EloquentModuleRepository(new \Modules\Isite\Entities\Module());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Isite\Repositories\Cache\CacheModuleDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Isite\Repositories\RevisionRepository',
            function () {
                $repository = new \Modules\Isite\Repositories\Eloquent\EloquentRevisionRepository(new \Modules\Isite\Entities\Revision());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Isite\Repositories\Cache\CacheRevisionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Isite\Repositories\ReportQueueRepository',
            function () {
                $repository = new \Modules\Isite\Repositories\Eloquent\EloquentReportQueueRepository(new \Modules\Isite\Entities\ReportQueue());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Isite\Repositories\Cache\CacheReportQueueDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Isite\Repositories\SiteRepository',
            function () {
                $repository = new \Modules\Isite\Repositories\Eloquent\EloquentSiteRepository(new \Modules\Isite\Entities\Site());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Isite\Repositories\Cache\CacheSiteDecorator($repository);
            }
        );
        // add bindings
    }

    private function registerMiddleware()
    {
        foreach ($this->middleware as $name => $class) {
            $this->app['router']->aliasMiddleware($name, $class);
        }
    }

    /**
     * Register Blade components
     */
    private function registerComponents()
    {
        Blade::componentNamespace("Modules\Isite\View\Components", 'isite');
    }

    /**
     * Register components Livewire
     */
    private function registerComponentsLivewire()
    {
        Livewire::component('isite::items-list', \Modules\Isite\Http\Livewire\Index\ItemsList::class);
        Livewire::component('isite::load-more-button', \Modules\Isite\Http\Livewire\Index\LoadMoreButton::class);
        Livewire::component('isite::item-modal', \Modules\Isite\Http\Livewire\Index\ItemModal::class);

        Livewire::component('isite::filters', \Modules\Isite\Http\Livewire\Filters::class);
        Livewire::component('isite::filter-range', \Modules\Isite\Http\Livewire\Filters\Range::class);
        Livewire::component('isite::filter-checkbox', \Modules\Isite\Http\Livewire\Filters\Checkbox::class);
        Livewire::component('isite::filter-radio', \Modules\Isite\Http\Livewire\Filters\Radio::class);
        Livewire::component('isite::filter-tree', \Modules\Isite\Http\Livewire\Filters\Tree::class);
        Livewire::component('isite::filter-select', \Modules\Isite\Http\Livewire\Filters\Select::class);
        Livewire::component('isite::filter-location', \Modules\Isite\Http\Livewire\Filters\Location::class);
        Livewire::component('isite::filter-text', \Modules\Isite\Http\Livewire\Filters\Text::class);
        Livewire::component('isite::filter-autocomplete', \Modules\Isite\Http\Livewire\Filters\Autocomplete::class);

        Livewire::component('isite::filter-order-by', \Modules\Isite\Http\Livewire\Index\Filters\OrderBy::class);
    }

    /**
     * Register the console commands
     */
    private function registerCommands()
    {
        $this->commands([
            GenerateSitemapCommand::class,
            TenantModuleMigrateCommand::class,
            TenantsScheduleCommand::class,
      TenantAiCommand::class,
        ]);
    }
}
