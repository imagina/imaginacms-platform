<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/ibuilder/v1'], function (Router $router) {
  $router->apiCrud([
    'module' => 'ibuilder',
    'prefix' => 'blocks',
    'controller' => 'BlockApiController',
    'middleware' => ['index' => [], 'show' => []]
  ]);
  // append
  $router->post("/block/preview", [
    'as' => 'ibuilder.blocks.preview.post',
    'uses' => 'BlockApiController@blockPreview',
  ]);

});
