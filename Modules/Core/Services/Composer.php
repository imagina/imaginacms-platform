<?php

namespace Modules\Core\Services;

use Symfony\Component\Process\Process;

class Composer extends \Illuminate\Support\Composer
{
    protected $outputHandler = null;

    private $output;

    /**
     * Enable real time output of all commands.
     */
    public function enableOutput($command): void
    {
        $this->output = function ($type, $buffer) use ($command) {
            if (Process::ERR === $type) {
                $command->info(trim('[ERR] > '.$buffer));
            } else {
                $command->info(trim('> '.$buffer));
            }
        };
    }

    /**
     * Disable real time output of all commands.
     */
    public function disableOutput(): void
    {
        $this->output = null;
    }

    /**
     * Update all composer packages.
     */
    public function update(string $package = null): void
    {
        if (! is_null($package)) {
            $package = '"'.$package.'"';
        }
        $process = $this->getProcess();
        $process->setCommandLine(trim($this->findComposer().' update '.$package));
        $process->run($this->output);
    }

    /**
     * Require a new composer package.
     */
    public function install(string $package): void
    {
        if (! is_null($package)) {
            $package = '"'.$package.'"';
        }
        $process = $this->getProcess();
        $process->setCommandLine(trim($this->findComposer().' require '.$package));
        $process->run($this->output);
    }

    public function dumpAutoload(): void
    {
        $process = $this->getProcess();
        $process->setCommandLine(trim($this->findComposer().' dump-autoload -o'));
        $process->run($this->output);
    }

    public function remove($package)
    {
        if (! is_null($package)) {
            $package = '"'.$package.'"';
        }
        $process = $this->getProcess();
        $process->setCommandLine(trim($this->findComposer().' remove '.$package));
        $process->run($this->output);
    }
}
