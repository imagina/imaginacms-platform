<?php

use Illuminate\Routing\Router;

$locale = LaravelLocalization::setLocale() ?: App::getLocale();

/** @var Router $router */
Route::prefix(trans('tag::tag.uri'))->group(function (Router $router) use ($locale) {
    $router->get('{slug}', [
        'as' => $locale.'.tag.slug',
        'uses' => 'PublicController@tag',
    ]);
});
