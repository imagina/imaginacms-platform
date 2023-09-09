<?php

namespace Modules\Media\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class RebuildThumbnails implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable;

    /**
     * @var Collection
     */
    private $paths;

    public function __construct(Collection $paths)
    {
        $this->paths = $paths;
        $this->queue = "media";
    }

    public function handle()
    {
        $imagy = app('imagy');

        foreach ($this->paths as $path) {
            try {
                app('log')->info('Generating thumbnails for path: '.$path);
                $imagy->createAll($path);
            } catch (\Exception $e) {
                app('log')->warning('File not found: '.$path);
            }
        }
    }
}
