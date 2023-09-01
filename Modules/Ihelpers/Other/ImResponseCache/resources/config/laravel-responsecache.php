<?php

return [
    /**
     *  This is the master switch to enable of disable the response cache. If set to
     *  false no responses will be cached.
     */
    'enabled' => env('RESPONSE_CACHE_ENABLED', true),

    /**
     *  The given class will determinate if a request should be cached. The
     *  default class will cache all successful GET-requests.
     *
     *  You can provide your own class given that it implements the
     *  CacheProfile interface.
     */
    'cacheProfile' => Modules\Ihelpers\Other\ImResponseCache\ImCacheProfile::class,

    /**
     * When using the default CacheRequestFilter this setting controls the
     * number of minutes responses must be cached.
     */
    'cacheLifetimeInMinutes' => 60 * 24,

    /*
     * This setting determines if a http header named "Laravel-responsecache"
     * with the cache time should be added to a cached response. This
     * can be handy when debugging.
     */
    'addCacheTimeHeader' => true,

    /*
     * Here you may define the cache store that should be used to store
     * requests. This can be the name of any store that is
     * configured in app/config/cache.php
     */
    'cacheStore' => env('RESPONSE_CACHE_DRIVER', 'file'),

    'public_page_cache' => true,

    'minifyhtml' => true,

    'cacheLoggedInUsers' => false,

    /*
     * You can define routes to pass to the function $request->is(). Example (backend*) (auth*)
     */
    'nocache' => ['backend*', 'auth*', 'isearch*', 'find-redirect*', 'index.php/*'],
];
