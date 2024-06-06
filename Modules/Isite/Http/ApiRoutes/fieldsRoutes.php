<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/fields'], function (Router $router) {
  $router->get('/', [
    'uses' => 'FieldsApiController@index'
  ]);
});

