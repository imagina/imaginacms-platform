<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'icommerceagree'], function (Router $router) {
    $router->get('/', [
        'as' => 'icommerceagree.api.agree.init',
        'uses' => 'IcommerceAgreeApiController@init',
    ]);
});
