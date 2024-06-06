<?php
use Illuminate\Routing\Router;
$router->group(['prefix' => '/rules'], function (Router $router) {
  
  
  $router->post('/', [
    'as' => 'api.notification.rules.create',
    'uses' => 'RuleApiController@create',
    //'middleware' => 'auth-can:notification.rules.create'
  ]);

  $router->get('/', [
    'as' => 'api.notification.rules.index',
    'uses' => 'RuleApiController@index',
    //'middleware' => 'auth-can:notification.rules.index'
  ]);
  
  $router->get('/config', [
    'as' => 'api.notification.rules.config',
    'uses' => 'RuleApiController@indexConfig',
    //'middleware' => 'auth-can:notification.rules.index'
  ]);
  $router->put('/{criteria}', [
    'as' => 'api.notification.rules.update',
    'uses' => 'RuleApiController@update',
   // 'middleware' => 'auth-can:notification.rules.create'
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.notification.rules.delete',
    'uses' => 'RuleApiController@delete',
    //'middleware' => 'auth-can:notification.rules.destroy'
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.notification.rules.show',
    'uses' => 'RuleApiController@show',
    //'middleware' => 'auth-can:notification.rules.show'
  ]);
  
});