<?php

namespace Modules\Core\Foundation\Asset\Types;

use FloatingPoint\Stylist\Facades\ThemeFacade as Theme;
use Illuminate\Support\Arr;

class ThemeAsset implements AssetType
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Get the URL
     */
    public function url()
    {
        return Theme::url($this->getPath());
    }

    private function getPath()
    {
        return Arr::get($this->path, 'theme');
    }
}
