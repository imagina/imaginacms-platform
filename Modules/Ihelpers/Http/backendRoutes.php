<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('/ihelpers')->group(function (Router $router) {
    $router->get('clearcache', [
        'as' => 'admin.ihelpers.clearcache',
        'uses' => 'IhelpersController@clearcache',
        'middleware' => 'can:dashboard.index',
    ]);
    $router->get('sitemapGet', [
        'as' => 'admin.ihelpers.sitemapGet',
        'uses' => 'IhelpersController@sitemapGet',
        'middleware' => 'can:dashboard.index',
    ]);

    $router->post('sitemapPost', [
        'as' => 'admin.ihelpers.sitemapPost',
        'uses' => 'IhelpersController@sitemapPost',
        'middleware' => 'can:dashboard.index',
    ]);
});
