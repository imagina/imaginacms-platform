<?php

namespace Modules\Ihelpers\Other\ImResponseCache;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Spatie\ResponseCache\CacheProfiles\CacheProfile;
use Spatie\ResponseCache\RequestHasher;
use Spatie\ResponseCache\ResponseCacheRepository;
use Symfony\Component\HttpFoundation\Response;

class ImResponseCache
{
    /**
     * @var ResponseCacher
     */
    protected $cache;

    /**
     * @var RequestHasher
     */
    protected $hasher;

    /**
     * @var CacheProfile
     */
    protected $cacheProfile;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    public function __construct(ResponseCacheRepository $cache, RequestHasher $hasher, CacheProfile $cacheProfile, Filesystem $files)
    {
        $this->cache = $cache;
        $this->hasher = $hasher;
        $this->cacheProfile = $cacheProfile;
        $this->files = $files;
    }

    /**
     * Determine if the given request should be cached.
     */
    public function shouldCache(Request $request, Response $response): bool
    {
        if (! config('laravel-responsecache.enabled')) {
            return false;
        }

        if ($request->attributes->has('laravel-cacheresponse.doNotCache')) {
            return false;
        }

        if (! $this->cacheProfile->shouldCacheRequest($request)) {
            return false;
        }

        return $this->cacheProfile->shouldCacheResponse($response);
    }

    /**
     * Store the given response in the cache.
     */
    public function cacheResponse(Request $request, Response $response)
    {
        if (config('laravel-responsecache.addCacheTimeHeader')) {
            $response = $this->addCachedHeader($response);
        }

        if (config('laravel-responsecache.minifyhtml')) {
            $buffer = $response->getContent();
            if (strpos($buffer, '<pre>') !== false) {
                $replace = [
                    '/<!--[^\[](.*?)[^\]]-->/s' => '',
                    "/<\?php/" => '<?php ',
                    "/\r/" => '',
                    "/>\n</" => '><',
                    "/>\s+\n</" => '><',
                    "/>\n\s+</" => '><',
                ];
            } else {
                $replace = [
                    '/<!--[^\[](.*?)[^\]]-->/s' => '',
                    "/<\?php/" => '<?php ',
                    "/\n([\S])/" => '$1',
                    "/\r/" => '',
                    "/\n/" => '',
                    "/\t/" => '',
                    '/ +/' => ' ',
                ];
            }
            $buffer = preg_replace(array_keys($replace), array_values($replace), $buffer);
            $response->setContent($buffer);
        }

        if (config('laravel-responsecache.public_page_cache')) {
            //$this->files->put(public_path().'/page-cache/'.$this->hasher->getHashFor($request), $response->getContent(), true);
            $this->public_cache($request, $response);
        }

        $this->cache->put($this->hasher->getHashFor($request), $response, $this->cacheProfile->cacheRequestUntil($request));
    }

    /**
     * Cache the response to a file.
     */
    public function public_cache(Request $request, Response $response): void
    {
        [$path, $file] = $this->getDirectoryAndFileNames($request);
        $this->files->makeDirectory($path, 0775, true, true);
        $this->files->put($path.$file, $response->getContent(), true);
    }

    /**
     * Get the names of the directory and file.
     */
    protected function getDirectoryAndFileNames(Request $request): array
    {
        $segments = explode('/', ltrim($request->getPathInfo(), '/'));
        $file = $this->aliasFilename(array_pop($segments)).'.html';

        return [$this->getCachePath(implode('/', $segments)), $file];
    }

    /**
     * Gets the path to the cache directory.
     *
     *
     * @throws \Exception
     */
    public function getCachePath(string $path = ''): string
    {
        $base = public_path().'/page-cache/';

        if (is_null($base)) {
            throw new Exception('Cache path not set.');
        }

        return $base.'/'.($path ? trim($path, '/').'/' : $path);
    }

    /**
     * Alias the filename if necessary.
     */
    protected function aliasFilename(string $filename): string
    {
        return $filename ?: 'pc__index__pc';
    }

    /**
     * Determine if the given request has been cached.
     */
    public function hasCached(Request $request): bool
    {
        return $this->cache->has($this->hasher->getHashFor($request));
    }

    /**
     * Get the cached response for the given request.
     */
    public function getCachedResponseFor(Request $request): Response
    {
        return $this->cache->get($this->hasher->getHashFor($request));
    }

    /**
     *  Flush the cache.
     */
    public function flush()
    {
        $this->cache->flush();
    }

    /**
     * Fully clear the cache directory.
     */
    public function flushPageCache(): bool
    {
        return $this->files->deleteDirectory($this->getCachePath(), true);
    }

    /**
     * Add a header with the cache date on the response.
     */
    protected function addCachedHeader(Response $response): Response
    {
        $clonedResponse = clone $response;

        $clonedResponse->header('Laravel-reponsecache', 'cached on '.date('Y-m-d H:i:s'));

        return $clonedResponse;
    }
}
