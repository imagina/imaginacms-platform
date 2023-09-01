<?php

namespace Modules\Core\Console\Installers\Scripts;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Modules\Core\Console\Installers\SetupScript;

class ConfigureUserProvider implements SetupScript
{
    /**
     * @var array
     */
    protected $drivers = [
        'Sentinel',
    ];

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
        $command->blockMessage('User Module', 'Starting the User Module setup...', 'comment');

        $this->configure('Sentinel', $command);
    }

    /**
     * @return mixed
     */
    protected function configure($driver, $command)
    {
        $driver = $this->factory($driver);

        return $driver->fire($command);
    }

    /**
     * @return mixed
     */
    protected function factory($driver)
    {
        $class = __NAMESPACE__."\\UserProviders\\{$driver}Installer";

        return $this->application->make($class);
    }
}
