<?php

use Illuminate\Routing\Router;

$locale = LaravelLocalization::setLocale() ?: App::getLocale();

/** @var Router $router */
Route::group(['prefix' => trans('tag::tag.uri')], function (Router $router) use ($locale) {
  $router->get('{slug}', [
    'as' => $locale . '.tag.slug',
    'uses' => 'PublicController@tag',
  ]);
});
