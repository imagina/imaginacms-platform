<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/menuitem', 'middleware' => 'api.token'], function (Router $router) {
  $router->post('/update', [
    'as' => 'api.menuitem.update',
    'uses' => 'MenuItemApiController@update',
    'middleware' => 'token-can:menu.menuitems.edit',
  ]);
  $router->post('/delete', [
    'as' => 'api.menuitem.delete',
    'uses' => 'MenuItemApiController@delete',
    'middleware' => 'token-can:menu.menuitems.destroy',
  ]);
});
