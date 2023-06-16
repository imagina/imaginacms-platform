<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => '/ibuilder'], function (Router $router) {
    $router->get('/block/preview', [
        'as' => 'ibuilder.blocks.preview',
        'uses' => 'PublicController@blockPreview',
    ]);
});
