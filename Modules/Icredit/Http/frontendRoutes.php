<?php

use Illuminate\Routing\Router;

Route::prefix('icredit')->group(function (Router $router) {
    $router->get('payment/{eUrl}', [
        'as' => 'icredit.payment.index',
        'uses' => 'PublicController@paymentIndex',
    ]);
});
