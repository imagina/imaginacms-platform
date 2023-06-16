<?php

use Illuminate\Routing\Router;

Route::prefix('/app')->middleware('auth:api')->group(function (Router $router) {
    $router->get('/version', [
        'as' => 'api.iprofile.app.version',
        'uses' => 'AppApiController@version',
    ]);
    $router->get('/permissions', [
        'as' => 'api.iprofile.app.permissions',
        'uses' => 'AppApiController@permissions',
    ]);
});
