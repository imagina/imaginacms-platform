<?php

use Illuminate\Routing\Router;


$router->group(['prefix' => 'ipin/v1'], function (Router $router) {
  //======  ADS
  require('ApiRoutes/adsRoutes.php');

  //======  CATEGORIES
  require('ApiRoutes/categoriesRoutes.php');

  //======  FIELDS
  //require('ApiRoutes/fieldsRoutes.php');

  //======  SCHEDULES
  //require('ApiRoutes/schedulesRoutes.php');

  //======  UPS
  require('ApiRoutes/upsRoutes.php');

  //======  ADUPS
  require('ApiRoutes/adUpsRoutes.php');
  
  // append
});
