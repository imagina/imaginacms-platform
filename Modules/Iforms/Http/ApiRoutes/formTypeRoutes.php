<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'form-types'], function (Router $router) {
    //Route index
    $router->get('/', [
        'as' => 'api.iforms.formTypes.index',
        'uses' => 'FormTypeApiController@index',
        'middleware' => ['auth:api'],
    ]);
});
