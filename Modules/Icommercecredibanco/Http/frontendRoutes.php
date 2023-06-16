<?php

use Illuminate\Routing\Router;

Route::prefix('icommercecredibanco')->group(function (Router $router) {
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();

    $router->get('voucher/order/{id}/{tid?}', [
        'as' => 'icommercecredibanco.voucher.show',
        'uses' => 'PublicController@voucherShow',
    ]);
});
