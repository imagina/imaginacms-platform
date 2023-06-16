<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('/menuitem')->middleware('api.token')->group(function (Router $router) {
    $router->post('/update', [
        'as' => 'api.menuitem.update',
        'uses' => 'MenuItemController@update',
        'middleware' => 'token-can:menu.menuitems.edit',
    ]);
    $router->post('/delete', [
        'as' => 'api.menuitem.delete',
        'uses' => 'MenuItemController@delete',
        'middleware' => 'token-can:menu.menuitems.destroy',
    ]);
});
Route::prefix('imenu')->group(function (Router $router) {
    // menu Routes
    require 'ApiRoutes/menuRoutes.php';

    // menuItems Routes
    require 'ApiRoutes/menuItemRoutes.php';

    // Legacy Api Routes
    require 'ApiRoutes/menuLegacyApiRoutes.php';
});
