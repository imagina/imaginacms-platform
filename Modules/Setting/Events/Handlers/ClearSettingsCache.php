<?php

namespace Modules\Setting\Events\Handlers;

use Modules\Setting\Repositories\Cache\CacheSettingDecorator;

class ClearSettingsCache
{
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(CacheSettingDecorator $cache)
    {
        $this->cache = $cache;
    }

    public function handle()
    {
      $this->cache->clearCache();
    }
}
