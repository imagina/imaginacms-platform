<?php

use Illuminate\Routing\Router;

Route::prefix('/ibuilder/v1')->group(function (Router $router) {
    $router->apiCrud([
        'module' => 'ibuilder',
        'prefix' => 'blocks',
        'controller' => 'BlockApiController',
        'middleware' => ['index' => [], 'show' => []],
    ]);
    // append
    $router->post('/block/preview', [
        'as' => 'ibuilder.blocks.preview.post',
        'uses' => 'BlockApiController@blockPreview',
    ]);
});
