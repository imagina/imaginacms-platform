<?php

namespace Modules\Core\Console\Installers\Scripts;

use Illuminate\Console\Command;
use Modules\Core\Console\Installers\SetupScript;

class ModuleSeeders implements SetupScript
{
    /**
     * @var array
     */
    protected $modules = [
        'Isite',
        'Ifillable',
        'Ischedulable',
        'Setting',
        'Page',
        'Ibanners',
        'Iblog',
        'Ilocations',
        'Iprofile',
        'Isite',
        'Notification',
      'Igamification',
      
    ];

    /**
     * Fire the install script
     *
     * @return mixed
     */
    public function fire(Command $command)
    {
        if ($command->option('verbose')) {
            $command->blockMessage('Seeds', 'Running the module seeds ...', 'comment');
        }

        foreach ($this->modules as $module) {
            if ($command->option('verbose')) {
                $command->call('module:seed', ['module' => $module]);

                continue;
            }
            $command->callSilent('module:seed', ['module' => $module]);
        }
    }
}
