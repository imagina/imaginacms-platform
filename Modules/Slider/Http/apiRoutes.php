<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/slider/v1'], function (Router $router) {

  $router->post('/update', [
    'as' => 'api.slide.update',
    'uses' => 'SlideController@update',
    'middleware' => 'token-can:slider.slides.update',
  ]);

  $router->post('/delete', [
    'as' => 'api.slide.delete',
    'uses' => 'SlideController@delete',
    'middleware' => 'token-can:slider.slides.destroy'
  ]);
  
  //======  SLIDERS
  require('ApiRoutes/sliderRoutes.php');
  
  //======  SLIDES
  require('ApiRoutes/slideRoutes.php');
});
