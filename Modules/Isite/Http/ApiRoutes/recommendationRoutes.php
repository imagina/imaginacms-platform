<?php

use Illuminate\Routing\Router;


$router->group(['prefix' => '/recommendations','middleware' => ['auth:api']], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.isite.recommendations.create',
    'uses' => 'RecommendationApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.isite.recommendations.index',
    'uses' => 'RecommendationApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.isite.recommendations.update',
    'uses' => 'RecommendationApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.isite.recommendations.delete',
    'uses' => 'RecommendationApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.isite.recommendations.show',
    'uses' => 'RecommendationApiController@show',
  ]);
  
});