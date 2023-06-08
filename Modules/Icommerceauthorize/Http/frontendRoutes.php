<?php

use Illuminate\Routing\Router;

    $router->group(['prefix'=>'icommerceauthorize'],function (Router $router){
        $locale = LaravelLocalization::setLocale() ?: App::getLocale();

        $router->get('/{eUrl}', [
            'as' => 'icommerceauthorize',
            'uses' => 'PublicController@index',
        ]);

        $router->get('/pay/{orderId}/{transactionId}/{oval}/{odes}', [
            'as' => 'icommerceauthorize.payment',
            'uses' => 'PublicController@payment',
        ]);
       

    });