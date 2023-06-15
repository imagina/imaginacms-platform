<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'icommerceflatrate'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'icommerceflatrate.api.flatrate.init',
        'uses' => 'IcommerceFlatrateApiController@init',
    ]);

   

});