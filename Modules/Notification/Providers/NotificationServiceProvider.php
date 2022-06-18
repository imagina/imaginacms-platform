<?php

namespace Modules\Notification\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Traits\CanGetSidebarClassForModule;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Notification\Composers\NotificationViewComposer;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Entities\Provider;
use Modules\Notification\Events\Handlers\NotificationHandler;
use Modules\Notification\Events\Handlers\RegisterNotificationSidebar;
use Modules\Notification\Repositories\Cache\CacheNotificationDecorator;
use Modules\Notification\Repositories\Eloquent\EloquentNotificationRepository;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\Notification\Repositories\ProviderRepository;
use Modules\Notification\Services\AsgardNotification;
use Modules\Notification\Services\ImaginaNotification;
use Modules\User\Contracts\Authentication;
use Illuminate\Support\Facades\Cache;

class NotificationServiceProvider extends ServiceProvider
{
  use CanPublishConfiguration, CanGetSidebarClassForModule;
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
    $this->registerViewComposers();


    $this->app['events']->listen(
      BuildingSidebar::class,
      $this->getSidebarClassForModule('blog', RegisterNotificationSidebar::class)
    );

    $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
      $event->load('notifications', Arr::dot(trans('notification::notifications')));

      // append translations


    });

  }

  public function boot()
  {
    $this->publishConfig('notification', 'config');
    $this->mergeConfigFrom($this->getModuleConfigFilePath('notification', 'permissions'), "asgard.notification.permissions");
    $this->mergeConfigFrom($this->getModuleConfigFilePath('notification', 'settings'), "asgard.notification.settings");
    $this->mergeConfigFrom($this->getModuleConfigFilePath('notification', 'settings-fields'), "asgard.notification.settings-fields");
    $this->mergeConfigFrom($this->getModuleConfigFilePath('notification', 'cmsPages'), "asgard.notification.cmsPages");
    $this->mergeConfigFrom($this->getModuleConfigFilePath('notification', 'cmsSidebar'), "asgard.notification.cmsSidebar");
    $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');


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
      NotificationRepository::class,
      function () {
        $repository = new EloquentNotificationRepository(new Notification());

        if (!config('app.cache')) {
          return $repository;
        }

        return new CacheNotificationDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Notification\Repositories\RuleRepository',
      function () {
        $repository = new \Modules\Notification\Repositories\Eloquent\EloquentRuleRepository(new \Modules\Notification\Entities\Rule());
        if (!config('app.cache')) {
          return $repository;
        }
        return new \Modules\Notification\Repositories\Cache\CacheRuleDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Notification\Repositories\ProviderRepository',
      function () {
        $repository = new \Modules\Notification\Repositories\Eloquent\EloquentProviderRepository(new \Modules\Notification\Entities\Provider());
        if (!config('app.cache')) {
          return $repository;
        }
        return new \Modules\Notification\Repositories\Cache\CacheProviderDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Notification\Repositories\TemplateRepository',
      function () {
        $repository = new \Modules\Notification\Repositories\Eloquent\EloquentTemplateRepository(new \Modules\Notification\Entities\Template());
        if (!config('app.cache')) {
          return $repository;
        }
        return new \Modules\Notification\Repositories\Cache\CacheTemplateDecorator($repository);
      }
    );

    $this->app->bind(\Modules\Notification\Services\Notification::class, function ($app) {
      return new AsgardNotification($app[NotificationRepository::class], $app[Authentication::class]);
    });

    $this->app->bind(\Modules\Notification\Services\Inotification::class, function ($app) {
      return new ImaginaNotification($app[NotificationRepository::class], $app[ProviderRepository::class], $app[Authentication::class]);
    });
  }

  private function registerViewComposers()
  {
    view()->composer('partials.top-nav', NotificationViewComposer::class);
  }



}
