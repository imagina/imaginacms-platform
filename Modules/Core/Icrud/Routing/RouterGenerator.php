<?php

namespace Modules\Core\Icrud\Routing;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
//Controllers
use Modules\Core\Icrud\Controllers\BaseCrudController;

class RouterGenerator
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Generate CRUD API routes
     *
     * @param  array  $params [module,prefix,controller]
     */
    public function apiCrud($params)
    {
        //Get routes
        $crudRoutes = isset($params['staticEntity']) ? $this->getStaticApiRoutes($params) :
          $crudRoutes = $this->getStandardApiRoutes($params);

        //Generate routes
        $this->router->group(['prefix' => $params['prefix']], function (Router $router) use ($crudRoutes) {
            foreach ($crudRoutes as $route) {
                $router->match($route->method, $route->path, $route->actions);
            }
        });
    }

    /**
     * Return routes to standar API
     */
    private function getStandardApiRoutes($params)
    {
        return [
            (object) [//Route create
                'method' => 'post',
                'path' => '/',
                'actions' => [
                    'as' => "api.{$params['module']}.{$params['prefix']}.create",
                    'uses' => $params['controller'].'@create',
                    'middleware' => isset($params['middleware']['create']) ? $params['middleware']['create'] : ['auth:api'],
                ],
            ],
            (object) [//Route index
                'method' => 'get',
                'path' => '/',
                'actions' => [
                    'as' => "api.{$params['module']}.{$params['prefix']}.index",
                    'uses' => $params['controller'].'@index',
                    'middleware' => isset($params['middleware']['index']) ? $params['middleware']['index'] : ['auth:api'],
                ],
            ],
            (object) [//Route show
                'method' => 'get',
                'path' => '/{criteria}',
                'actions' => [
                    'as' => "api.{$params['module']}.{$params['prefix']}.show",
                    'uses' => $params['controller'].'@show',
                    'middleware' => isset($params['middleware']['show']) ? $params['middleware']['show'] : ['auth:api'],
                ],
            ],
            (object) [//Route Update
                'method' => 'put',
                'path' => '/{criteria}',
                'actions' => [
                    'as' => "api.{$params['module']}.{$params['prefix']}.update",
                    'uses' => $params['controller'].'@update',
                    'middleware' => isset($params['middleware']['update']) ? $params['middleware']['update'] : ['auth:api'],
                ],
            ],
            (object) [//Route delete
                'method' => 'delete',
                'path' => '/{criteria}',
                'actions' => [
                    'as' => "api.{$params['module']}.{$params['prefix']}.delete",
                    'uses' => $params['controller'].'@delete',
                    'middleware' => isset($params['middleware']['delete']) ? $params['middleware']['delete'] : ['auth:api'],
                ],
            ],
            (object) [//Route delete
                'method' => 'put',
                'path' => '/{criteria}/restore',
                'actions' => [
                    'as' => "api.{$params['module']}.{$params['prefix']}.restore",
                    'uses' => $params['controller'].'@restore',
                    'middleware' => isset($params['middleware']['restore']) ? $params['middleware']['restore'] : ['auth:api'],
                ],
            ],
            (object) [//Route bulk order
                'method' => 'put',
                'path' => '/bulk/order',
                'actions' => [
                    'as' => "api.{$params['module']}.{$params['prefix']}.bulk-order",
                    'uses' => $params['controller'].'@bulkOrder',
                    'middleware' => isset($params['middleware']['order']) ? $params['middleware']['order'] : ['auth:api'],
                ],
            ],
        ];
    }

    /**
     * Return the static api routes to static entities
     */
    private function getStaticApiRoutes($params)
    {
        //Instance controller
        $controller = new BaseCrudController();

        return [
            (object) [//Route Index
                'method' => 'get',
                'path' => '/',
                'actions' => function (Request $request) use ($controller, $params) {
                    //Call indexStatic method from controller
                    return $controller->indexStatic($request, [
                        'entityClass' => $params['staticEntity'],
                        'method' => isset($params['use']['index']) ? $params['use']['index'] : 'index',
                    ]
                    );
                },
            ],
            (object) [//Route Show
                'method' => 'get',
                'path' => '/{criteria}',
                'actions' => function ($criteria, Request $request) use ($controller, $params) {
                    //Call showStatic method from controller
                    return $controller->showStatic($criteria, $request, [
                        'entityClass' => $params['staticEntity'],
                        'method' => isset($params['use']['show']) ? $params['use']['show'] : 'show',
                    ]
                    );
                },
            ],
        ];
    }
}
