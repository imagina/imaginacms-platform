<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/export'], function (Router $router) {
    $router->get('/', [
        'as' => 'api.isite.export.get',
        'uses' => 'ExportApiController@show',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/{fileName}', [
        'as' => 'api.isite.export.download',
        'uses' => 'ExportApiController@download',
        //'middleware' => ['auth:api']
    ]);
    $router->post('/', [
        'as' => 'api.isite.export.post',
        'uses' => 'ExportApiController@create',
        'middleware' => ['auth:api'],
    ]);
});
