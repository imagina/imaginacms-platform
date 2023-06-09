<?php

namespace Modules\Core\Foundation\Theme;

class AssetPublisher
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $finder;

    /**
     * @var ThemeManager
     */
    protected $repository;

    /**
     * @var Theme
     */
    private $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return $this
     */
    public function setFinder($finder): static
    {
        $this->finder = $finder;

        return $this;
    }

    /**
     * @return $this
     */
    public function setRepository($repository): static
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * Publish the assets
     */
    public function publish()
    {
        if (! $this->finder->isDirectory($sourcePath = $this->getSourcePath())) {
            $message = "Source path does not exist : {$sourcePath}";
            throw new \InvalidArgumentException($message);
        }
        if (! $this->finder->isDirectory($destinationPath = $this->getDestinationPath())) {
            $this->finder->makeDirectory($destinationPath, 0775, true);
        }
        if ($this->finder->copyDirectory($sourcePath, $destinationPath)) {
            return true;
        }
    }

    /**
     * Get the original source path
     *
     * @return string
     */
    public function getSourcePath(): string
    {
        return $this->theme->getPath().'/assets';
    }

    /**
     * Get the destination path
     *
     * @return string
     */
    public function getDestinationPath(): string
    {
        return $this->repository->getAssetPath($this->theme->getLowerName());
    }
}
