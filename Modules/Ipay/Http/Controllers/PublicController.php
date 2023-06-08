<?php

namespace Modules\Ipay\Http\Controllers;

use Mockery\CountValidator\Exception;
use Modules\Ipay\Entities\Category;
use Modules\Ipay\Entities\Article;

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





    public function getAll() {

        //Json Response.
        $response = array();

        try {

            $config = Article::all(['id','title','description']);

            $response['status'] = 'success';

            $response['data'] = array();
            $response['data']['content'] = $config;

        } catch(\Exception $e) {
            $response['status'] = 'error';
            $response['msg']= $e->getMessage();

        }

        return response()->json($response);

    }

    public function respuesta(){
        return 1;
    }

}
