<?php

use Illuminate\Routing\Router;

Route::group(['prefix'=>'icommercepaymentez'],function (Router $router){
       
    $router->get('/{eUrl}', [
        'as' => 'icommercepaymentez',
        'uses' => 'PublicController@index',
    ]);

    $router->get('/confirmation/{orderId}', [
        'as' => 'icommercepaymentez.confirmation',
        'uses' => 'PublicController@confirmation',
    ]);
  
       
});