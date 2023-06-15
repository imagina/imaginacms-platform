<?php

use Illuminate\Routing\Router;
/** @var Router $router */


Route::group(['prefix' => 'iredirect/v1'], function (Router $router) {
  
  //======  PAGES
  require('ApiRoutes/redirectRoutes.php');
  
  
});
