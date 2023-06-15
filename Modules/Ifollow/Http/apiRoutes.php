<?php

use Illuminate\Routing\Router;

Route::group(['prefix' =>'/ifollow/v1'], function (Router $router) {
    $router->apiCrud([
      'module' => 'ifollow',
      'prefix' => 'followers',
      'controller' => 'FollowerApiController',
      'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
// append

});
