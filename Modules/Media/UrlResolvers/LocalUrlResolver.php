<?php

namespace Modules\Media\UrlResolvers;

use League\Flysystem\Adapter\Local;

class LocalUrlResolver
{
    public function resolve(Local $adapter, string $path): string
    {
        return asset($path);
    }
}
