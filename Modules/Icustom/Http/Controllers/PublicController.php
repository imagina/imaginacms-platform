<?php

namespace Modules\Icustom\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;

class PublicController extends BasePublicController
{
    /**
     * @var Application
     */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;

        //parent::__construct();
    }
}
