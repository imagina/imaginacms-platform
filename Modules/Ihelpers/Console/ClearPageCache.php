<?php

namespace Modules\Ihelpers\Console;

use Illuminate\Cache\CacheManager;
use Illuminate\Console\Command;
use Modules\Ihelpers\Other\ImResponseCache\ImResponseCache;

class ClearPageCache extends Command
{
    protected $signature = 'pagecache:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the Full Page Cache.';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $imresponsecache = $this->laravel->make(ImResponseCache::class);
        //Clear cache for spatie cache.
        $imresponsecache->flush();
        //Clear page cache in html files.
        $imresponsecache->flushPageCache();

        //Old way
        //$storeName = config('laravel-responsecache.cacheStore');
        //app(CacheManager::class)->store($storeName)->flush();
    }
}
