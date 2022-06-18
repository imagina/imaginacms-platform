<?php namespace Modules\Ibanners\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Modules\Ibanners\Entities\Position;
use Modules\Ibanners\Entities\Banner;
use Modules\Ibanners\Presenters\BannerAdsPresenter;
use Modules\Ibanners\Repositories\Cache\CachePositionDecorator;
use Modules\Ibanners\Repositories\Cache\CacheBannerDecorator;
use Modules\Ibanners\Repositories\Eloquent\EloquentBannerApiRepository;
use Modules\Ibanners\Repositories\Eloquent\EloquentPositionRepository;
use Modules\Ibanners\Repositories\Eloquent\EloquentBannerRepository;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Ibanners\Events\Handlers\RegisterIbannersSidebar;
use Modules\Core\Events\LoadingBackendTranslations;

class IbannersServiceProvider extends ServiceProvider
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
      $this->registerBindings();
      $this->app['events']->listen(BuildingSidebar::class, RegisterIbannersSidebar::class);

      $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
          $event->load('position', Arr::dot(trans('ibanners::position')));
          $event->load('banners', Arr::dot(trans('ibanners::banners')));
          // append translations

      });
  }

  /**
   * Register all online positions on the Pingpong/Menu package
   */
  public function boot()
  {
    $this->publishConfig('ibanners', 'config');
    $this->publishConfig('ibanners', 'permissions');

    $this->mergeConfigFrom($this->getModuleConfigFilePath('ibanners', 'cmsPages'), "asgard.ibanners.cmsPages");
    $this->mergeConfigFrom($this->getModuleConfigFilePath('ibanners', 'cmsSidebar'), "asgard.ibanners.cmsSidebar");

    $this->registerPositions();
    $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'ibanners');
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return array('bannersAds');
  }

  /**
   * Register class binding
   */
  private function registerBindings()
  {
    $this->app->bind(
      'Modules\Ibanners\Repositories\PositionRepository',
      function () {
        $repository = new EloquentPositionRepository(new Position());

        if (!config('app.cache')) {
          return $repository;
        }

        return new CachePositionDecorator($repository);
      }
    );

    $this->app->bind(
      'Modules\Ibanners\Repositories\BannerRepository',
      function () {
        $repository = new EloquentBannerRepository(new Banner());

        if (!config('app.cache')) {
          return $repository;
        }

        return new CacheBannerDecorator($repository);
      }
    );

    $this->app->bind(BannerAdsPresenter::class);
  }

  /**
   * Register the active positions
   */
  private function registerPositions()
  {
    if (!$this->app['asgard.isInstalled']) {
      return;
    }
  }

}
