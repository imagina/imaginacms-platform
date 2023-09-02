<?php

namespace Modules\Core\Foundation\Asset\Types;

use Illuminate\Support\Arr;

class CdnAsset implements AssetType
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
        return Arr::get($this->path, 'cdn');
    }
}
