<?php

namespace Modules\Workshop\Manager;

use FloatingPoint\Stylist\Theme\Exceptions\ThemeNotFoundException;
use FloatingPoint\Stylist\Theme\Json;
use FloatingPoint\Stylist\Theme\Theme;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Symfony\Component\Yaml\Parser;

class StylistThemeManager implements ThemeManager
{
    /**
     * @var Filesystem
     */
    private $finder;

    public function __construct(Filesystem $finder)
    {
        $this->finder = $finder;
    }

    public function all(): array
    {
        $directories = $this->getDirectories();

        $themes = [];
        foreach ($directories as $directory) {
            $themes[] = $this->getThemeInfoForPath($directory);
        }

        return $themes;
    }

    /**
     *
     * @throws ThemeNotFoundException
     */
    public function find(string $themeName): Theme
    {
        foreach ($this->getDirectories() as $directory) {
            if (strtolower(basename($directory)) !== strtolower($themeName)) {
                continue;
            }

            return $this->getThemeInfoForPath($directory);
        }

        throw new ThemeNotFoundException($themeName);
    }

    private function getThemeInfoForPath(string $directory): Theme
    {
        $themeJson = new Json($directory);

        $theme = new Theme(
            $themeJson->getJsonAttribute('name'),
            $themeJson->getJsonAttribute('description'),
            $directory,
            $themeJson->getJsonAttribute('parent')
        );
        $theme->version = $themeJson->getJsonAttribute('version');
        $theme->type = ucfirst($themeJson->getJsonAttribute('type'));
        $theme->changelog = $this->getChangelog($directory);
        $theme->active = $this->getStatus($theme);

        return $theme;
    }

    /**
     * Get all theme directories
     */
    private function getDirectories(): array
    {
        $themePath = config('stylist.themes.paths', [base_path('/Themes')]);

        return $this->finder->directories($themePath[0]);
    }

    /**
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function getChangelog(string $directory): array
    {
        if (! $this->finder->isFile($directory.'/changelog.yml')) {
            return [];
        }

        $yamlFile = $this->finder->get($directory.'/changelog.yml');

        $yamlParser = new Parser();

        $changelog = $yamlParser->parse($yamlFile);

        $changelog['versions'] = $this->limitLastVersionsAmount(Arr::get($changelog, 'versions', []));

        return $changelog;
    }

    /**
     * Limit the versions to the last 5
     */
    private function limitLastVersionsAmount(array $versions): array
    {
        return array_slice($versions, 0, 5);
    }

    /**
     * Check if the theme is active based on its type
     */
    private function getStatus(Theme $theme): bool
    {
        if ($theme->type !== 'Backend') {
            return setting('core::template') === $theme->getName();
        }

        return config('asgard.core.core.admin-theme') === $theme->getName();
    }
}
