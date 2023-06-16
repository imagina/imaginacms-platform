<?php

use Illuminate\Routing\Router;

Route::prefix('form-types')->group(function (Router $router) {
    //Route index
    $router->get('/', [
        'as' => 'api.iforms.formTypes.index',
        'uses' => 'FormTypeApiController@index',
        'middleware' => ['auth:api'],
    ]);
});
