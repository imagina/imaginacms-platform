<?php

namespace Modules\Ipay\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Ipay\Entities\Article;

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

    public function getAll()
    {
        //Json Response.
        $response = [];

        try {
            $config = Article::all(['id', 'title', 'description']);

            $response['status'] = 'success';

            $response['data'] = [];
            $response['data']['content'] = $config;
        } catch(\Exception $e) {
            $response['status'] = 'error';
            $response['msg'] = $e->getMessage();
        }

        return response()->json($response);
    }

    public function respuesta()
    {
        return 1;
    }
}
