<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/sliders'], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

  $router->post('/', [
    'as' => $locale . 'api.slider.sliders.create',
    'uses' => 'SliderApiController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.slider.sliders.index',
    'uses' => 'SliderApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.slider.sliders.update',
    'uses' => 'SliderApiController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.slider.sliders.delete',
    'uses' => 'SliderApiController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.slider.sliders.show',
    'uses' => 'SliderApiController@show',
  ]);

  $router->post('/order-slides', [
    'as' => $locale . 'api.slider.sliders.slide.update',
    'uses' => 'SlideController@update',
    'middleware' => ['auth:api']
  ]);

});
