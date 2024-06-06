<?php

namespace Modules\Ihelpers\Other\ImResponseCache;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\ResponseCache\CacheProfiles\BaseCacheProfile;
use Spatie\ResponseCache\CacheProfiles\CacheProfile;

class ImCacheProfile extends BaseCacheProfile implements CacheProfile
{
    /**
     * Determine if the given request should be cached;.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function shouldCacheRequest(Request $request)
    {
        if ($request->ajax()) {
            return false;
        }

        if(!config('laravel-responsecache.cacheLoggedInUsers') || !$request->user()) {
            return false;
        }

        if ($this->isRunningInConsole()) {
            return false;
        }

        $nocache = config('laravel-responsecache.nocache');
        if(is_array($nocache)) {

            foreach($nocache as $pattern) {
                if ($request->is($pattern)) {
                    return false;
                }
            }

        }

        return $request->isMethod('get');
    }

    /**
     * Determine if the given response should be cached.
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return bool
     */
    public function shouldCacheResponse(Response $response)
    {
        return $response->isSuccessful() || $response->isRedirection();
    }
}
