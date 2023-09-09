<?php

namespace Modules\Media\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Media\Entities\File;

class CreateThumbnails implements ShouldQueue
{
  use InteractsWithQueue, SerializesModels, Queueable;

    /**
     * @var MediaPath
     */
    private $path;

    /**
     * @var mixed|null
     */
    private $disk = null;
  private $file;

  public function __construct(File $file)
    {
    $this->path = $file->path;
    $this->disk = $file->disk;
    $this->file = $file;
    $this->queue = "media";
    }

    public function handle()
    {
        $imagy = app('imagy');

        app('log')->info('Generating thumbnails for path: '.$this->path.((! is_null($this->disk)) ? ' in disk: '.$this->disk : ''));

        $imagy->createAll($this->path, $this->disk);
    //update attribute has_thumbnails
    $this->file->has_thumbnails = true;
    $this->file->update();
    }
}
