<?php

namespace Modules\Page\Services;

use Symfony\Component\Finder\Finder;

class FinderService
{
    protected $filesystem;

    public function __construct()
    {
        $this->filesystem = Finder::create()->files();
    }

    public function excluding(array $excludes): static
    {
        $this->filesystem = $this->filesystem->exclude($excludes);

        return $this;
    }

    /**
     * Get all of the files from the given directory (recursive).
     */
    public function allFiles(string $directory, bool $hidden = false): array
    {
        return iterator_to_array($this->filesystem->ignoreDotFiles(! $hidden)->in($directory), false);
    }
}
