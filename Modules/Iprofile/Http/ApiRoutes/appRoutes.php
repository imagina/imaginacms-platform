<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/app','middleware' => ['auth:api']], function (Router $router) {
  $router->get('/version', [
    'as' => 'api.iprofile.app.version',
    'uses' => 'AppApiController@version',
  ]);
  $router->get('/permissions', [
    'as' => 'api.iprofile.app.permissions',
    'uses' => 'AppApiController@permissions',
  ]);
});