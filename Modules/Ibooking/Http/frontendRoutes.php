<?php

use Illuminate\Routing\Router;

$locale = LaravelLocalization::setLocale() ?: App::getLocale();

/** @var Router $router */
Route::group(['prefix' => LaravelLocalization::setLocale()], function (Router $router) use ($locale) {
  //Show Resources data
  $router->get('ibooking/' . trans('ibooking::routes.resources') . '/{resourceId}', [
    'as' => 'ibooking.resources.show',
    'uses' => 'PublicController@showResources',
  ]);
});
