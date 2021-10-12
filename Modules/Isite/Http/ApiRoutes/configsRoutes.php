<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/configs'], function (Router $router) {
  $router->get('/', [
    'uses' => 'ConfigsApiController@index'
  ]);
});

