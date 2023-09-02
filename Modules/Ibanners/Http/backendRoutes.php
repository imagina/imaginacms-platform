<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->bind('position', function ($id) {
    return app(\Modules\Ibanners\Repositories\PositionRepository::class)->find($id);
});
$router->bind('banner', function ($id) {
    return app(\Modules\Ibanners\Repositories\BannerRepository::class)->find($id);
});

Route::prefix('/ibanners')->group(function (Router $router) {
    $router->get('positions', [
        'as' => 'admin.ibanners.position.index',
        'uses' => 'PositionController@index',
    ]);
    $router->get('positions/create', [
        'as' => 'admin.ibanners.position.create',
        'uses' => 'PositionController@create',
    ]);
    $router->post('positions', [
        'as' => 'admin.ibanners.position.store',
        'uses' => 'PositionController@store',
    ]);
    $router->get('positions/{position}/edit', [
        'as' => 'admin.ibanners.position.edit',
        'uses' => 'PositionController@edit',
    ]);
    $router->put('positions/{position}', [
        'as' => 'admin.ibanners.position.update',
        'uses' => 'PositionController@update',
    ]);
    $router->delete('positions/{position}', [
        'as' => 'admin.ibanners.position.destroy',
        'uses' => 'PositionController@destroy',
    ]);

    $router->get('positions/{position}/banner', [
        'as' => 'dashboard.banner.index',
        'uses' => 'BannerController@index',
    ]);
    $router->get('positions/{position}/banner/create', [
        'as' => 'dashboard.banner.create',
        'uses' => 'BannerController@create',
    ]);
    $router->post('positions/{position}/banner', [
        'as' => 'dashboard.banner.store',
        'uses' => 'BannerController@store',
    ]);
    $router->get('positions/{position}/banner/{banner}/edit', [
        'as' => 'dashboard.banner.edit',
        'uses' => 'BannerController@edit',
    ]);
    $router->put('positions/{position}/banner/{banner}', [
        'as' => 'dashboard.banner.update',
        'uses' => 'BannerController@update',
    ]);
    $router->delete('positions/{position}/banner/{banner}', [
        'as' => 'dashboard.banner.destroy',
        'uses' => 'BannerController@destroy',
    ]);
});
