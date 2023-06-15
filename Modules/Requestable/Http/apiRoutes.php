<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::group(['prefix' => '/requestable/v1'], function (Router $router) {
  
  $router->apiCrud([
    'module' => 'requestable',
    'prefix' => 'categories',
    'controller' => 'CategoryApiController',
    'middleware' => [
      'index' => [],
      'show' => [],
      'create' => ['auth:api','auth-can:requestable.categories.create'],
      'update' => ['auth:api','auth-can:requestable.categories.edit']
    ]
  ]);
  
  $router->apiCrud([
    'module' => 'requestable',
    'prefix' => 'statuses',
    'controller' => 'StatusApiController',
    'middleware' => [
      'index' => ['auth:api','auth-can:requestable.statuses.index'],
      'show' => ['auth:api','auth-can:requestable.statuses.show'],
      'create' => ['auth:api','auth-can:requestable.statuses.create'],
      'update' => ['auth:api','auth-can:requestable.statuses.edit'],
      'delete' => ['auth:api','auth-can:requestable.statuses.destroy'],
    ]
  ]);
  
  $router->apiCrud([
    'module' => 'requestable',
    'prefix' => 'requestables',
    'controller' => 'RequestableApiController',
    'middleware' => [
      'index' => ['auth:api','auth-can:requestable.requestables.index'],
      'show' => ['auth:api','auth-can:requestable.requestables.index'],
      'create' => ['auth:api','auth-can:requestable.requestables.create'],
      'update' => ['auth:api','auth-can:requestable.requestables.edit']

    ]
  ]);

  $router->apiCrud([
    'module' => 'requestable',
    'prefix' => 'category-rule',
    'controller' => 'CategoryRuleApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:requestable.categoryrules.create'],
      'update' => ['auth:api','auth-can:requestable.categoryrules.edit'],
      'delete' => ['auth:api','auth-can:requestable.categoryrules.destroy'],
    ]
  ]);

  $router->apiCrud([
    'module' => 'requestable',
    'prefix' => 'automation-rule',
    'controller' => 'AutomationRuleApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:requestable.automationrules.create'],
      'update' => ['auth:api','auth-can:requestable.automationrules.edit'],
      'delete' => ['auth:api','auth-can:requestable.automationrules.destroy']
    ]
  ]);

  /**
   * Requestable with Icomments Module
  */
  if (is_module_enabled('Icomments')) {
    $router->apiCrud([
      'module' => 'requestable',
      'prefix' => 'comments',
      'controller' => '\Modules\Icomments\Http\Controllers\Api\CommentApiController',
      'middleware' => [
        'create' => ['auth:api','auth-can:requestable.comments.create'],
        'update' => ['auth:api','auth-can:requestable.comments.edit'],
        'delete' => ['auth:api','auth-can:requestable.comments.destroy']
      ]
    ]);
  }
  

  
  
  //======  REQUESTS
  require('ApiRoutes/requestablesRoutes.php');

  require('ApiRoutes/statusesRoutes.php');

  require('ApiRoutes/categoriesRoutes.php');

});
