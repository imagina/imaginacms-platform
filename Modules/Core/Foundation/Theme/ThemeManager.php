<?php

namespace Modules\Core\Foundation\Theme;

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

    /**
     * @param  string     $name
     * @return Theme|null
     */
    public function find($name)
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
    public function all()
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
    public function allPublicThemes()
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
    private function getDirectories()
    {
        return $this->getFinder()->directories($this->path);
    }

    /**
     * Return the theme assets path
     */
    public function getAssetPath($theme)
    {
        return public_path($this->getConfig()->get('themify.themes_assets_path').'/'.$theme);
    }

    /**
     * @return \Illuminate\Filesystem\Filesystem
     */
    protected function getFinder()
    {
        return $this->app['files'];
    }

    /**
     * @return \Illuminate\Config\Repository
     */
    protected function getConfig()
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
    private function getThemeJsonFile($theme)
    {
        return json_decode($this->getFinder()->get("$theme/theme.json"));
    }

    private function isFrontendTheme($themeJson)
    {
        return isset($themeJson->type) && $themeJson->type !== 'frontend' ? false : true;
    }
}
