<?php

namespace Modules\Core\Console\Installers;

use Illuminate\Console\Command;

interface SetupScript
{
    /**
     * Fire the install script
     *
     * @return mixed
     */
    public function fire(Command $command);
}
