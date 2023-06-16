<?php

use Illuminate\Routing\Router;

Route::prefix('icommercecredibanco')->group(function (Router $router) {
    $router->get('/', [
        'as' => 'icommercecredibanco.api.credibanco.init',
        'uses' => 'IcommerceCredibancoApiController@init',
    ]);

    $router->get('/getUpdateOrder', [
        'as' => 'icommercecredibanco.api.credibanco.getUpdateOrder',
        'uses' => 'IcommerceCredibancoApiController@getUpdateOrder',
    ]);
});
