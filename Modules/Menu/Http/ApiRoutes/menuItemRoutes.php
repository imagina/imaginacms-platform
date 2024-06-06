<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/menuitem'], function (Router $router) {
    $router->post('/', [
        'as' => 'api.imenu.menuitem.create',
        //'middleware' => ['auth:api'],
        'uses' => 'MenuItemApiController@create',
    ]);
    $router->get('/', [
        'as' => 'api.imenu.menuitem.index',
        'uses' => 'MenuItemApiController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.imenu.menuitem.update',
        //'middleware' => ['auth:api'],
        'uses' => 'MenuItemApiController@update',
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.imenu.menuitem.delete',
        //'middleware' => ['auth:api'],
        'uses' => 'MenuItemApiController@delete',
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.imenu.menuitem.show',
        'uses' => 'MenuItemApiController@show',
    ]);
    //Route update
    $router->put('update-items/{criteria}', [
        'as' => 'api.imenu.menuitem.updateItems',
        'uses' => 'MenuItemApiController@updateItems',
        'middleware' => ['auth:api']
    ]);

    //Route delete
    $router->delete('delete-items/{criteria}', [
        'as' => 'api.imenu.menuitem.deleteItems',
        'uses' => 'MenuItemApiController@deleteItems',
        'middleware' => ['auth:api']
    ]);

    $router->post('/ordener', [
      'as' => 'api.imenu.menuitem.update.ordener',
      'uses' => 'MenuItemApiController@updateOrderner',
      'middleware' => ['auth:api']
    ]);

});
