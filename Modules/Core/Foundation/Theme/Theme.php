<?php

namespace Modules\Core\Foundation\Theme;

class Theme
{
    /**
     * @var string the theme name
     */
    private $name;

    /**
     * @var string the theme path
     */
    private $path;

    public function __construct($name, $path)
    {
        $this->name = $name;
        $this->path = realpath($path);
    }

    public function getName(): string
    {
        return ucfirst($this->name);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get name in lower case.
     */
    public function getLowerName(): string
    {
        return strtolower($this->name);
    }
}
