<?php

use Illuminate\Routing\Router;

Route::prefix('ipoint')->group(function (Router $router) {
    $router->get('payment/{eUrl}', [
        'as' => 'ipoint.payment.index',
        'uses' => 'PublicController@paymentIndex',
    ]);
});
