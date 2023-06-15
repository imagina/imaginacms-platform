<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => '/price-lists'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

  $router->post('/', [
    'as' => $locale . 'api.icommercepricelist.price-lists.create',
    'uses' => 'PriceListApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommercepricelist.price-lists.index',
    'uses' => 'PriceListApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommercepricelist.price-lists.update',
    'uses' => 'PriceListApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommercepricelist.price-lists.delete',
    'uses' => 'PriceListApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommercepricelist.price-lists.show',
    'uses' => 'PriceListApiController@show',
  ]);

});
