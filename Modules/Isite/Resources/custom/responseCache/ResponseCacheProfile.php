<?php

namespace Modules\Isite\Resources\custom\responseCache;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Spatie\ResponseCache\CacheProfiles\BaseCacheProfile;

class ResponseCacheProfile extends BaseCacheProfile
{
  public function shouldCacheRequest(Request $request): bool
  {
    if ($request->ajax()) {
      return false;
    }

    if ($this->isRunningInConsole()) {
      return false;
    }

    $nocache = config('responsecache.no_cache');
    if (is_array($nocache)) {
      foreach ($nocache as $pattern) {
        if ($request->is($pattern)) {
          return false;
        }
      }
    }

    return $request->isMethod('get');
  }

  public function shouldCacheResponse(Response $response): bool
  {
    if (!$this->hasCacheableResponseCode($response)) {
      return false;
    }

    if (!$this->hasCacheableContentType($response)) {
      return false;
    }

    return true;
  }

  public function hasCacheableResponseCode(Response $response): bool
  {
    if ($response->isSuccessful()) {
      return true;
    }

    if ($response->isRedirection()) {
      return true;
    }

    return false;
  }

  public function hasCacheableContentType(Response $response): bool
  {
    $contentType = $response->headers->get('Content-Type', '');

    if (Str::startsWith($contentType, 'text/')) {
      return true;
    }

    if (Str::contains($contentType, ['/json', '+json'])) {
      return true;
    }

    return false;
  }
}
