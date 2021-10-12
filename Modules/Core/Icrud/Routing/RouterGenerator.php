<?php

namespace Modules\Core\Icrud\Routing;

use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Http\Request;

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
   * @param array $params [module,prefix,controller]
   */
  public function apiCrud($params)
  {
    //Instance CRUD routes
    $crudRoutes = [
      (object)[//Route create
        'method' => 'post',
        'path' => '/',
        'actions' => [
          'as' => "api.{$params['module']}.{$params['prefix']}.create",
          'uses' => $params['controller'] . "@create",
          'middleware' => isset($params['middleware']['create']) ? $params['middleware']['create'] : ['auth:api']
        ]
      ],
      (object)[//Route index
        'method' => 'get',
        'path' => '/',
        'actions' => [
          'as' => "api.{$params['module']}.{$params['prefix']}.index",
          'uses' => $params['controller'] . "@index",
          'middleware' => isset($params['middleware']['index']) ? $params['middleware']['index'] : ['auth:api']
        ]
      ],
      (object)[//Route show
        'method' => 'get',
        'path' => '/{criteria}',
        'actions' => [
          'as' => "api.{$params['module']}.{$params['prefix']}.show",
          'uses' => $params['controller'] . "@show",
          'middleware' => isset($params['middleware']['show']) ? $params['middleware']['show'] : ['auth:api']
        ]
      ],
      (object)[//Route Update
        'method' => 'put',
        'path' => '/{criteria}',
        'actions' => [
          'as' => "api.{$params['module']}.{$params['prefix']}.update",
          'uses' => $params['controller'] . "@update",
          'middleware' => isset($params['middleware']['update']) ? $params['middleware']['update'] : ['auth:api']
        ]
      ],
      (object)[//Route delete
        'method' => 'delete',
        'path' => '/{criteria}',
        'actions' => [
          'as' => "api.{$params['module']}.{$params['prefix']}.delete",
          'uses' => $params['controller'] . "@delete",
          'middleware' => isset($params['middleware']['delete']) ? $params['middleware']['delete'] : ['auth:api']
        ]
      ],
      (object)[//Route delete
        'method' => 'put',
        'path' => '/{criteria}/restore',
        'actions' => [
          'as' => "api.{$params['module']}.{$params['prefix']}.restore",
          'uses' => $params['controller'] . "@restore",
          'middleware' => isset($params['middleware']['restore']) ? $params['middleware']['restore'] : ['auth:api']
        ]
      ]
    ];

    //Generate routes
    $this->router->group(['prefix' => $params['prefix']], function (Router $router) use ($crudRoutes) {
      foreach ($crudRoutes as $route) {
        $router->match($route->method, $route->path, $route->actions);
      }
    });
  }
}
