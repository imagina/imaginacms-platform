<?php

use Illuminate\Routing\Router;

$locale = LaravelLocalization::setLocale() ?: App::getLocale();

/** @var Router $router */
Route::prefix(LaravelLocalization::setLocale())->middleware('localize')->group(function (Router $router) use ($locale) {
    $router->get(trans('iad::routes.ad.index.index'), [
        'as' => $locale.'.iad.ad.index',
        'uses' => 'PublicController@index',
    ]);

    $router->get(trans('iad::routes.ad.index.category'), [
        'as' => $locale.'.iad.ad.index.category',
        'uses' => 'PublicController@index',
    ]);

    $router->get(trans('iad::routes.ad.index.service'), [
        'as' => $locale.'.iad.ad.index.service',
        'uses' => 'PublicController@index',
    ]);

    $router->get(trans('iad::routes.ad.show.ad'), [
        'as' => $locale.'.iad.ad.show',
        'uses' => 'PublicController@show',
    ]);
});

Route::prefix('/pins')->group(function (Router $router) {
    $router->get('{pinSlug}/buy-up', [
        'as' => 'pins.ad.by-up',
        'uses' => 'PublicController@buyUp',
        'middleware' => 'logged.in',
    ]);

    $router->post('{pinId}/buy-up', [
        'as' => 'pins.ad.by-up.post',
        'uses' => 'PublicController@buyUpStore',
        'middleware' => 'logged.in',
    ]);
});
