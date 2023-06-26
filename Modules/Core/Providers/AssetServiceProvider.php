<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Foundation\Asset\Manager\AsgardAssetManager;
use Modules\Core\Foundation\Asset\Manager\AssetManager;
use Modules\Core\Foundation\Asset\Pipeline\AsgardAssetPipeline;
use Modules\Core\Foundation\Asset\Pipeline\AssetPipeline;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->bindAssetClasses();
    }

    /**
     * Bind classes related to assets
     */
    private function bindAssetClasses()
    {
        $this->app->singleton(AssetManager::class, function () {
            return new AsgardAssetManager();
        });

        $this->app->singleton(AssetPipeline::class, function ($app) {
            return new AsgardAssetPipeline($app[AssetManager::class]);
        });
    }
}
