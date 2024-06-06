<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/isite/v1'], function (Router $router) {
  //======  SETTINGS
  require('ApiRoutes/settingsRoutes.php');
  //======  APP
  require('ApiRoutes/siteRoutes.php');
  //======  Fields
  require('ApiRoutes/fieldsRoutes.php');
});
