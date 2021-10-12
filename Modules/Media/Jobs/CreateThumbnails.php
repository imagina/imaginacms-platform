<?php

namespace Modules\Media\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Media\ValueObjects\MediaPath;

class CreateThumbnails implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var MediaPath
     */
    private $path;
    /**
     * @var mixed|null
     */
    private $disk = null;

    public function __construct(MediaPath $path, $disk = null)
    {
        $this->path = $path;
        $this->disk = $disk;
    }

    public function handle()
    {
        $imagy = app('imagy');

        app('log')->info('Generating thumbnails for path: ' . $this->path.((!is_null($this->disk))?' in disk: '.$this->disk:''));

        $imagy->createAll($this->path,$this->disk);
    }
}
