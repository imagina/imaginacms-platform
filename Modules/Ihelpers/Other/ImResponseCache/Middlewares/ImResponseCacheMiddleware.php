<?php

namespace Modules\Ihelpers\Other\ImResponseCache\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Modules\Ihelpers\Other\ImResponseCache\ImResponseCache as ResponseCache;

class ImResponseCacheMiddleware
{
    /**
     * @var \Spatie\ResponseCache\ResponseCache
     */
    protected $responseCache;

    public function __construct(ResponseCache $responseCache)
    {
        $this->responseCache = $responseCache;
    }

    public function handle(Request $request, Closure $next): Request
    {
        if ($this->responseCache->hasCached($request)) {
            return $this->responseCache->getCachedResponseFor($request);
        }

        $response = $next($request);

        if ($this->responseCache->shouldCache($request, $response)) {
            $this->responseCache->cacheResponse($request, $response);
        }

        return $response;
    }
}
