<?php

namespace Modules\Core\Foundation\Theme;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;

class ThemeManager implements \Countable
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var string Path to scan for themes
     */
    private $path;

    public function __construct(Application $app, $path)
    {
        $this->app = $app;
        $this->path = $path;
    }

    public function find(string $name): ?Theme
    {
        foreach ($this->all() as $theme) {
            if ($theme->getLowerName() == strtolower($name)) {
                return $theme;
            }
        }
    }

    /**
     * Return all available themes
     */
    public function all(): array
    {
        $themes = [];
        if (! $this->getFinder()->isDirectory($this->path)) {
            return $themes;
        }

        $directories = $this->getDirectories();

        foreach ($directories as $theme) {
            if (Str::startsWith($name = basename($theme), '.')) {
                continue;
            }
            $themes[$name] = new Theme($name, $theme);
        }

        return $themes;
    }

    /**
     * Get only the public themes
     */
    public function allPublicThemes(): array
    {
        $themes = [];
        if (! $this->getFinder()->isDirectory($this->path)) {
            return $themes;
        }

        $directories = $this->getDirectories();

        foreach ($directories as $theme) {
            if (Str::startsWith($name = basename($theme), '.')) {
                continue;
            }
            $themeJson = $this->getThemeJsonFile($theme);
            if ($this->isFrontendTheme($themeJson)) {
                $themes[$name] = new Theme($name, $theme);
            }
        }

        return $themes;
    }

    /**
     * Get the theme directories
     */
    private function getDirectories(): array
    {
        return $this->getFinder()->directories($this->path);
    }

    /**
     * Return the theme assets path
     */
    public function getAssetPath(string $theme): string
    {
        return public_path($this->getConfig()->get('themify.themes_assets_path').'/'.$theme);
    }

    protected function getFinder(): Filesystem
    {
        return $this->app['files'];
    }

    protected function getConfig(): Repository
    {
        return $this->app['config'];
    }

    /**
     * Counts all themes
     */
    public function count()
    {
        return count($this->all());
    }

    /**
     * Returns the theme json file
     *
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function getThemeJsonFile($theme): string
    {
        return json_decode($this->getFinder()->get("$theme/theme.json"));
    }

    private function isFrontendTheme($themeJson): bool
    {
        return isset($themeJson->type) && $themeJson->type !== 'frontend' ? false : true;
    }
}
