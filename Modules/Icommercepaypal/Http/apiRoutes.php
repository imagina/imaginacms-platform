<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'icommercepaypal'], function (Router $router) {
    $router->get('/', [
        'as' => 'icommercepaypal.api.paypal.init',
        'uses' => 'IcommercePaypalApiController@init',
    ]);
});
