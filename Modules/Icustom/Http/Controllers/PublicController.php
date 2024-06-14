<?php

namespace Modules\Icustom\Http\Controllers;

use Mockery\CountValidator\Exception;
use Modules\Icustom\Http\Requests\IcustomRequest;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Request;
use Log;

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
