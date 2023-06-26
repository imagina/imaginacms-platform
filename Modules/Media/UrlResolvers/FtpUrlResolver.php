<?php

namespace Modules\Media\UrlResolvers;

use League\Flysystem\Adapter\Ftp;

class FtpUrlResolver
{
    /**
     * @param  string  $path
     * @return string
     */
    public function resolve(Ftp $adapter, string $path): string
    {
        return 'ftp://'.config('filesystems.disks.ftp.host').$path;
    }
}
