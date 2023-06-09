<?php

namespace Modules\Core\Traits;

use Modules\Core\Foundation\Asset\Pipeline\AssetPipeline;

trait CanRequireAssets
{
    /**
     * Require a css asset from the asset pipeline
     *
     * @param  string  $name
     */
    public function requireCss(string $name)
    {
        app(AssetPipeline::class)->requireCss($name);
    }

    /**
     * Require a js asset from the asset pipeline
     *
     * @param  string  $name
     */
    public function requireJs(string $name)
    {
        app(AssetPipeline::class)->requireJs($name);
    }
}
