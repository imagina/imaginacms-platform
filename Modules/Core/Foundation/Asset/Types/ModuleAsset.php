<?php

namespace Modules\Core\Foundation\Asset\Types;

use Illuminate\Support\Arr;
use Nwidart\Modules\Facades\Module;

class ModuleAsset implements AssetType
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Get the URL
     */
    public function url(): string
    {
        return Module::asset($this->getPath());
    }

    private function getPath()
    {
        return Arr::get($this->path, 'module');
    }
}
