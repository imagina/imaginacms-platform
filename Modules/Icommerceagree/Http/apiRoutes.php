<?php

use Illuminate\Routing\Router;

Route::prefix('icommerceagree')->group(function (Router $router) {
    $router->get('/', [
        'as' => 'icommerceagree.api.agree.init',
        'uses' => 'IcommerceAgreeApiController@init',
    ]);
});
