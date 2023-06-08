<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/wishlistable'], function (Router $router) {
    $router->bind('wishlistable', function ($id) {
        return app('Modules\Wishlistable\Repositories\WishlistableRepository')->find($id);
    });
    $router->get('wishlistables', [
        'as' => 'admin.wishlistable.wishlistable.index',
        'uses' => 'WishlistableController@index',
        'middleware' => 'can:wishlistable.wishlistables.index'
    ]);
    $router->get('wishlistables/create', [
        'as' => 'admin.wishlistable.wishlistable.create',
        'uses' => 'WishlistableController@create',
        'middleware' => 'can:wishlistable.wishlistables.create'
    ]);
    $router->post('wishlistables', [
        'as' => 'admin.wishlistable.wishlistable.store',
        'uses' => 'WishlistableController@store',
        'middleware' => 'can:wishlistable.wishlistables.create'
    ]);
    $router->get('wishlistables/{wishlistable}/edit', [
        'as' => 'admin.wishlistable.wishlistable.edit',
        'uses' => 'WishlistableController@edit',
        'middleware' => 'can:wishlistable.wishlistables.edit'
    ]);
    $router->put('wishlistables/{wishlistable}', [
        'as' => 'admin.wishlistable.wishlistable.update',
        'uses' => 'WishlistableController@update',
        'middleware' => 'can:wishlistable.wishlistables.edit'
    ]);
    $router->delete('wishlistables/{wishlistable}', [
        'as' => 'admin.wishlistable.wishlistable.destroy',
        'uses' => 'WishlistableController@destroy',
        'middleware' => 'can:wishlistable.wishlistables.destroy'
    ]);
// append

});
