<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => '/product-lists'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  $router->post('/', [
    'as' => $locale . 'api.icommercepricelist.product-lists.create',
    'uses' => 'ProductListApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommercepricelist.product-lists.index',
    'uses' => 'ProductListApiController@index',
  ]);
  $router->put('/{id}', [
    'as' => $locale . 'api.icommercepricelist.product-lists.update',
    'uses' => 'ProductListApiController@update',
  ]);
  $router->delete('/{id}', [
    'as' => $locale . 'api.icommercepricelist.product-lists.delete',
    'uses' => 'ProductListApiController@delete',
  ]);
  $router->get('/{id}', [
    'as' => $locale . 'api.icommercepricelist.product-lists.show',
    'uses' => 'ProductListApiController@show',
  ]);

});
