<?php

use Illuminate\Routing\Router;

Route::prefix('/batchs')->middleware('auth:api')->group(function (Router $router) {
    $router->post('/move', [
        'as' => 'api.imedia.batchs.move',
        'uses' => 'NewApi\BatchApiController@move',
        'middleware' => 'auth-can:media.batchs.move',
    ]);

    $router->post('/destroy', [
        'as' => 'api.imedia.batchs.destroy',
        'uses' => 'NewApi\BatchApiController@destroy',
        'middleware' => 'auth-can:media.batchs.destroy',
    ]);
});
