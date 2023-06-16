<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'ipoint'], function (Router $router) {
    $router->get('payment/{eUrl}', [
        'as' => 'ipoint.payment.index',
        'uses' => 'PublicController@paymentIndex',
    ]);
});
