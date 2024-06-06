<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Storage;

/** @var Router $router */
$router->group(['prefix' => '/storage','middleware' => ['auth:api']], function (Router $router) {

  $router->get('/assets/media/{path}', [
    'as' => 'public.media.media.show',
    'uses' => 'Frontend\MediaController@show',
    'middleware' =>  'auth-can:media.medias.show'
  ]);
  
});
/*
$router->get('storage/assets/media/{path}',[
    'as' => 'public.media.media.show',
    'uses' => 'Frontend\MediaController@show',
]);
*/