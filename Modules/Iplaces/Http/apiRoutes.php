<?php

use Illuminate\Routing\Router;


$router->group(['prefix' => 'iplaces/v1'], function (Router $router) {

  //======  PLACES
  require('ApiRoutes/placesRoutes.php');

  //======  CATEGORIES
  require('ApiRoutes/categoriesRoutes.php');

  //======  SCHEDULES
  require('ApiRoutes/schedulesRoutes.php');

  //======  SERVICES
  require('ApiRoutes/servicesRoutes.php');

  //======  SPACES
  require('ApiRoutes/spacesRoutes.php');

  //======  ZONES
  require('ApiRoutes/zonesRoutes.php');

});