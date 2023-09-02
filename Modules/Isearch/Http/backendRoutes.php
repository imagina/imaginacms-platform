<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('/isearch')->group(function (Router $router) {
    /*$router->get('isearch', [
        'as' => 'admin.isearch.modules.index',
        'uses' => 'IsearchController@index',
        //'middleware' => 'can:page.pages.index',
    ]);*/
});
