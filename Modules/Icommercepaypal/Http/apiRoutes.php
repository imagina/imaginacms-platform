<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'icommercepaypal'], function (Router $router) {
    $router->get('/', [
        'as' => 'icommercepaypal.api.paypal.init',
        'uses' => 'IcommercePaypalApiController@init',
    ]);
});
