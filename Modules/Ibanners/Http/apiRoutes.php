<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('/v1/ibanners')->group(function (Router $router) {
    $router->post('banners/update', [
        'as' => 'api.banner.update',
        'uses' => 'BannerController@update',
        //'middleware' => 'token-can:ibanners.banners.update',
    ]);

    $router->post('banners/delete', [
        'as' => 'api.banner.delete',
        'uses' => 'BannerController@delete',
        'middleware' => 'token-can:ibanners.banners.destroy',
    ]);

    //======  SLIDERS
    require 'ApiRoutes/positionRoutes.php';

    //======  SLIDES
    require 'ApiRoutes/bannerRoutes.php';
});
