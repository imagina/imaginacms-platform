<?php

use Illuminate\Routing\Router;

Route::prefix('types')->group(function (Router $router) {
    //Route index
    $router->get('/', [
        'as' => 'api.iforms.types.index',
        'uses' => 'TypeApiController@index',
        'middleware' => ['auth:api'],
    ]);
});
