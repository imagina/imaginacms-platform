<?php

use Illuminate\Routing\Router;

$router->group(['prefix'=>'icommerceopenpay'],function (Router $router){
       
    $router->get('/{eUrl}', [
        'as' => 'icommerceopenpay',
        'uses' => 'PublicController@index',
    ]);
  
       
});