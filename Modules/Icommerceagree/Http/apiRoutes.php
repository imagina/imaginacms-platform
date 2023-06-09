<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'icommerceagree'], function (Router $router) {
    $router->get('/', [
        'as' => 'icommerceagree.api.agree.init',
        'uses' => 'IcommerceAgreeApiController@init',
    ]);
});
