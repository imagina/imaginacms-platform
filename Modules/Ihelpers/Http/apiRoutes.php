<?php

use Illuminate\Routing\Router;

/*Routes API*/
$router->group(['prefix' => '/menu'], function (Router $router) {
  $router->get('/{id}', [
    'as' => 'api.menu.show',
    'uses' => 'MenuApiController@show',
  ]);
});
