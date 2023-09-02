<?php

use Illuminate\Routing\Router;

Route::prefix('/wishlistable/v1')->group(function (Router $router) {
    Route::prefix('/wishlist')->group(function (Router $router) {
        $router->post('/', [
            'as' => 'api.wishlistable.wishlist.create',
            'uses' => 'WishlistableApiController@create',
            'middleware' => ['auth:api'],
        ]);
        $router->get('/', [
            'as' => 'api.wishlistable.wishlist.index',
            'uses' => 'WishlistableApiController@index',
        ]);
        $router->get('/{criteria}', [
            'as' => 'api.wishlistable.wishlist.show',
            'uses' => 'WishlistableApiController@show',
        ]);
        $router->put('/{criteria}', [
            'as' => 'api.wishlistable.wishlist.update',
            'uses' => 'WishlistableApiController@update',
            'middleware' => ['auth:api'],
        ]);
        $router->delete('/{criteria}', [
            'as' => 'api.wishlistable.wishlist.delete',
            'uses' => 'WishlistableApiController@delete',
            'middleware' => ['auth:api'],
        ]);
    });
});
