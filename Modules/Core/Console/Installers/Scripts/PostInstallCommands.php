<?php

namespace Modules\Core\Console\Installers\Scripts;

use Illuminate\Console\Command;
use Modules\Core\Console\Installers\SetupScript;

class PostInstallCommands implements SetupScript
{
    /**
     * @var array
     */
    protected $postCommands = [
        'key:generate' => [],
        'migrate' => [],
        'passport:install' => [],
        'module:publish-config' => [
            '-f',
        ],
        'module:publish' => [],
    ];

    /**
     * Fire the install script
     *
     * @return mixed
     */
    public function fire(Command $command)
    {
        if ($command->option('verbose')) {
            $command->blockMessage('Post Install Commands', 'Executing post install commands ...', 'comment');
        }

        foreach ($this->postCommands as $postCommand => $options) {
            if ($command->option('verbose')) {
                $command->call($postCommand, $options);

                continue;
            }
            $command->callSilent($postCommand, $options);
        }
    }
}
