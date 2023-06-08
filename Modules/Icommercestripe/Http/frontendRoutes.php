<?php

use Illuminate\Routing\Router;

$router->group(['prefix'=>'icommercestripe'],function (Router $router){
       
    $router->get('/{eUrl}', [
        'as' => 'icommercestripe',
        'uses' => 'PublicController@index',
    ]);

    $router->get('connect/refresh/url', [
        'as' => 'icommercestripe.connect.refresh.url',
        'uses' => 'PublicController@connectRefreshUrl'
        //'middleware' => ['auth']
    ]);
       
});