<?php

namespace Modules\Core\Support;

trait SupportsCacheTags
{
    /**
     * Checks if the cache tags functionality is supported with the current driver
     */
    public function cacheTagsAreSupported(): bool
    {
        return ! in_array(config('cache.default'), ['file', 'database']);
    }
}
