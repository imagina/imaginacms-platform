<?php

namespace Modules\Core\Console\Installers\Scripts;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Encryption\Encrypter;
use Modules\Core\Console\Installers\SetupScript;

class SetAppKey implements SetupScript
{
    use ConfirmableTrait;

    /**
     * @var Application
     */
    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Fire the install script
     *
     * @return mixed
     */
    public function fire(Command $command)
    {
        $key = $this->generateRandomKey();

        // Next, we will replace the application key in the environment file so it is
        // automatically setup for this developer. This key gets generated using a
        // secure random byte generator and is later base64 encoded for storage.
        if (! $this->setKeyInEnvironmentFile($key)) {
            return;
        }

        config()->set('app.key', $key);

        if ($command->option('verbose')) {
            $command->info("Application key [$key] set successfully.");
        }
    }

    /**
     * Generate a random key for the application.
     */
    protected function generateRandomKey(): string
    {
        return 'base64:'.base64_encode(
            Encrypter::generateKey(config('app.cipher'))
        );
    }

    /**
     * Set the application key in the environment file.
     */
    protected function setKeyInEnvironmentFile(string $key): bool
    {
        $currentKey = config('app.key');

        if (strlen($currentKey) !== 0 && (! $this->confirmToProceed())) {
            return false;
        }

        $this->writeNewEnvironmentFileWith($key);

        return true;
    }

    /**
     * Write a new environment file with the given key.
     */
    protected function writeNewEnvironmentFileWith(string $key): void
    {
        file_put_contents(app()->environmentFilePath(), preg_replace(
            $this->keyReplacementPattern(),
            'APP_KEY='.$key,
            file_get_contents(app()->environmentFilePath())
        ));
    }

    /**
     * Get a regex pattern that will match env APP_KEY with any random key.
     */
    protected function keyReplacementPattern(): string
    {
        $escaped = preg_quote('='.config('app.key'), '/');

        return "/^APP_KEY{$escaped}/m";
    }

    /**
     * Get the default confirmation callback.
     */
    protected function getDefaultConfirmCallback(): callable
    {
        return function () {
            return $this->application->environment() === 'production';
        };
    }
}
