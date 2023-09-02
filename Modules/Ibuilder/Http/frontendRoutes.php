<?php

use Illuminate\Routing\Router;

Route::prefix('/ibuilder')->group(function (Router $router) {
    $router->get('/block/preview', [
        'as' => 'ibuilder.blocks.preview',
        'uses' => 'PublicController@blockPreview',
    ]);
});
