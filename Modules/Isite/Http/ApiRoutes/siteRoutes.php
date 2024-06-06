<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/site'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $router->get('/version', [
    'as' => 'api.isite.version',
    'uses' => 'SiteApiController@version',
  ]);
  $router->get('/permissions', [
    'as' => 'api.isite.permissions',
    'uses' => 'SiteApiController@permissions',
    'middleware' => ['auth:api']
  ]);
  $router->get('/settings', [
    'as' => 'api.isite.index',
    'uses' => 'SiteApiController@index',
  ]);
});
