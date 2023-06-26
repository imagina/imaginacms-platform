<?php

namespace Modules\Core\Events;

use Illuminate\Support\Str;
use Modules\Core\Foundation\Asset\Pipeline\AssetPipeline;

class CollectingAssets
{
    /**
     * @var AssetPipeline
     */
    private $assetPipeline;

    public function __construct(AssetPipeline $assetPipeline)
    {
        $this->assetPipeline = $assetPipeline;
    }

    /**
     * @param  string  $asset
     * @return AssetPipeline
     */
    public function requireJs(string $asset): AssetPipeline
    {
        return $this->assetPipeline->requireJs($asset);
    }

    /**
     * @param  string  $asset
     * @return AssetPipeline
     */
    public function requireCss(string $asset): AssetPipeline
    {
        return $this->assetPipeline->requireCss($asset);
    }

    /**
     * Match a single route
     *
     * @param  string|array  $route
     * @return bool
     */
    public function onRoute($route): bool
    {
        $request = request();

        return Str::is($route, $request->route()->getName());
    }

    /**
     * Match multiple routes
     *
     * @return bool
     */
    public function onRoutes(array $routes): bool
    {
        $request = request();

        foreach ($routes as $route) {
            if (Str::is($route, $request->route()->getName()) === true) {
                return true;
            }
        }

        return false;
    }
}
