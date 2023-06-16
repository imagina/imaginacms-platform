<?php

use Illuminate\Routing\Router;

$locale = LaravelLocalization::setLocale() ?: App::getLocale();

/** @var Router $router */
Route::prefix(LaravelLocalization::setLocale())->middleware('localize')->group(function (Router $router) use ($locale) {
    $router->get(trans('wishlistable::routes.wishlist.index'), [
        'as' => $locale.'.wishlistable.wishlist.index',
        'uses' => 'PublicController@index',
        'middleware' => ['auth', 'doNotCacheResponse'],
    ]);
});
