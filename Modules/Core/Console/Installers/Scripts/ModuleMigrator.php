<?php

namespace Modules\Core\Console\Installers\Scripts;

use Illuminate\Console\Command;
use Modules\Core\Console\Installers\SetupScript;

class ModuleMigrator implements SetupScript
{
    /**
     * @var array
     */
    protected $modules = [
        'Isite',
        'Ifillable',
        'Ischedulable',
        'Setting',
        'Menu',
        'Media',
        'Notification',
        'Page',
        'Dashboard',
        'Translation',
        'Slider',
        'Tag',
        'Ibanners',
        'Iblog',
        'Iforms',
        'Iprofile',
        'Ilocations',
        'Iredirect'
    ];

    /**
     * Fire the install script
     * @param  Command $command
     * @return mixed
     */
    public function fire(Command $command)
    {
        if ($command->option('verbose')) {
            $command->blockMessage('Migrations', 'Starting the module migrations ...', 'comment');
        }
  
      $command->call('module:migrate');
        
        /*foreach ($this->modules as $module) {
            if ($command->option('verbose')) {
                $command->call('module:migrate');
                continue;
            }
            $command->callSilent('module:migrate');
        }*/
    }
}
