<?php

use Illuminate\Routing\Router;

    $router->group(['prefix'=>'icommerceepayco'],function (Router $router){
        $locale = LaravelLocalization::setLocale() ?: App::getLocale();
  
      $router->get('/{eUrl}', [
            'as' => 'icommerceepayco',
            'uses' => 'PublicController@index',
        ]);

      $router->get('/payment/response/{orderId}', [
        'as' => 'icommerceepayco.response',
        'uses' => 'PublicController@response',
      ]);
        
      
       
    });