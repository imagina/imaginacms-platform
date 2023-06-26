<?php

namespace Modules\Core\Console\Installers\Scripts;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository as Config;
use Modules\Core\Console\Installers\SetupScript;
use Modules\Core\Console\Installers\Writers\EnvFileWriter;

class ConfigureAppUrl implements SetupScript
{
    protected $config;

    /**
     * @var EnvFileWriter
     */
    protected $env;

    public function __construct(Config $config, EnvFileWriter $env)
    {
        $this->config = $config;
        $this->env = $env;
    }

    /**
     * @var Command
     */
    protected $command;

    /**
     * Fire the install script
     *
     * @return mixed
     */
    public function fire(Command $command)
    {
        $this->command = $command;

        $vars = [];

        $vars['app_url'] = $this->askAppUrl();

        $this->setLaravelConfiguration($vars);

        $this->env->write($vars);

        if ($command->option('verbose')) {
            $command->info('Application url successfully configured');
        }
    }

    /**
     * Ensure that the APP_URL is valid
     *
     * e.g. http://localhost, http://192.168.0.10, https://www.example.com etc.
     */
    protected function askAppUrl(): string
    {
        do {
            $str = $this->command->ask('Enter you application url (e.g. http://localhost, http://dev.example.com)', 'http://localhost');

            if ($str == '' || (strpos($str, 'http://') !== 0 && strpos($str, 'https://') !== 0)) {
                $this->command->error('A valid http:// or https:// url is required');

                $str = false;
            }
        } while (! $str);

        return $str;
    }

    protected function setLaravelConfiguration($vars)
    {
        $this->config['app.url'] = $vars['app_url'];
    }
}
