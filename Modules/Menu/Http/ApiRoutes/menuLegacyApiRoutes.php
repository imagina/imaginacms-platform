<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('/menuitem')->middleware('api.token')->group(function (Router $router) {
    $router->post('/update', [
        'as' => 'api.imenuitem.update',
        'uses' => 'MenuItemApiController@update',
        'middleware' => 'token-can:menu.menuitems.edit',
    ]);
    $router->post('/delete', [
        'as' => 'api.imenuitem.delete',
        'uses' => 'MenuItemApiController@delete',
        'middleware' => 'token-can:menu.menuitems.destroy',
    ]);
});
