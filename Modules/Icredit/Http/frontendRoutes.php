<?php

use Illuminate\Routing\Router;

$router->group(['prefix'=>'icredit'],function (Router $router){
       
    $router->get('payment/{eUrl}', [
        'as' => 'icredit.payment.index',
        'uses' => 'PublicController@paymentIndex',
    ]);
       
});