<?php

namespace Modules\Media\Events\Handlers;

use Illuminate\Contracts\Filesystem\Factory;
use Modules\Media\Events\FolderIsDeleting;

class DeleteFolderOnDisk
{
    /**
     * @var Factory
     */
    private $finder;

    public function __construct(Factory $finder)
    {
        $this->finder = $finder;
    }

    public function handle(FolderIsDeleting $event)
    {
        $disk = is_null($event->folder->disk)? $this->getConfiguredFilesystem() : $event->folder->disk;
        $this->finder->disk($disk)->deleteDirectory($this->getDestinationPath($event->folder->getRawOriginal('path')));
    }

    /**
     * @param string $path
     * @return string
     */
    private function getDestinationPath($path)
    {
        if ($this->getConfiguredFilesystem() === 'local') {
            return basename(public_path()) . $path;
        }

        return $path;
    }

    /**
     * @return string
     */
    private function getConfiguredFilesystem()
    {
        return setting('media::filesystem', null, config("asgard.media.config.filesystem"));
    }
}
