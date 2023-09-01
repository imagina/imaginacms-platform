<?php

use Illuminate\Routing\Router;

$locale = LaravelLocalization::setLocale() ?: App::getLocale();

/** @var Router $router */
Route::prefix(LaravelLocalization::setLocale())->group(function (Router $router) {
    //Show Resources data
    $router->get('ibooking/'.trans('ibooking::routes.resources').'/{resourceId}', [
        'as' => 'ibooking.resources.show',
        'uses' => 'PublicController@showResources',
    ]);
});
