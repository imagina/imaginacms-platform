<?php

namespace Modules\Media\ValueObjects;

use Illuminate\Support\Facades\Storage;

class MediaPath
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $disk;

    /**
     * @var string
     */
    private $file;

    /**
     * @var int
     */
    private $organizationId;

    public function __construct($path, $disk = null, $organizationId = null, $file = null)
    {
        if (! is_string($path)) {
            throw new \InvalidArgumentException('The path must be a string');
        }
        $this->path = $path;

        $this->disk = $disk;

        $this->organizationId = $organizationId;

        $this->file = $file;
    }

    /**
     * Get the URL depending on configured disk
     */
    public function getUrl(string $disk = null, $organizationId = null): string
    {
        $path = ltrim($this->path, '/');
        $disk = is_null($disk) ? is_null($this->disk) ? setting('media::filesystem', null, config('asgard.media.config.filesystem')) : $this->disk : $disk;
        $organizationPrefix = mediaOrganizationPrefix($this->file, '', '/', $organizationId, true);

        return Storage::disk($disk)->url(($organizationPrefix).$path);
    }

    public function getRelativeUrl(): string
    {
        return $this->path;
    }

    public function __toString()
    {
        try {
            return $this->getUrl($this->disk, $this->organizationId);
        } catch (\Exception $e) {
            return '';
        }
    }
}
