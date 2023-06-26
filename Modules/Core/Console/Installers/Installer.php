<?php

namespace Modules\Core\Console\Installers;

use Illuminate\Console\Command;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Modules\Core\Services\Composer;

class Installer
{
    /**
     * @var array
     */
    protected $scripts = [];

    public function __construct(Application $app, Filesystem $finder, Composer $composer)
    {
        $this->finder = $finder;
        $this->app = $app;
        $this->composer = $composer;
    }

    public function stack(array $scripts): static
    {
        $this->scripts = $scripts;

        return $this;
    }

    /**
     * Fire install scripts
     */
    public function install(Command $command): bool
    {
        foreach ($this->scripts as $script) {
            try {
                $this->app->make($script)->fire($command);
            } catch (\Exception $e) {
                $command->error($e->getMessage());

                return false;
            }
        }

        return true;
    }
}
