<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/slides'], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.slider.slides.create',
    'uses' => 'SlideApiController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.slider.slides.index',
    'uses' => 'SlideApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.slider.slides.update',
    'uses' => 'SlideApiController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.slider.slides.delete',
    'uses' => 'SlideApiController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.slider.slides.show',
    'uses' => 'SlideApiController@show',
  ]);
  
});