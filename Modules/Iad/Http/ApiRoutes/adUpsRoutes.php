<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'pin-ups'], function (Router $router) {

  $router->get('/', [
    'as' => 'api.iad.ad-ups.index',
    'uses' => 'AdUpApiController@index',
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.iad.ad-ups.show',
    'uses' => 'AdUpApiController@show',
  ]);

});
