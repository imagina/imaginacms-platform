<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/profile/v1'], function (Router $router) {
  
  //======  AUTH
  require('ApiRoutes/authRoutes.php');
  
  //======  ADDRESSES
  require('ApiRoutes/addressRoutes.php');
  
  //======  FIELDS
  require('ApiRoutes/fieldRoutes.php');
  
  //======  DEPARTMENTS
  require('ApiRoutes/departmentRoutes.php');
  
  //======  DEPARTMENT SETTINGS
  require('ApiRoutes/settingRoutes.php');
  
  //======  ROLES
  require('ApiRoutes/roleRoutes.php');
  
  //======  USERS
  require('ApiRoutes/userRoutes.php');

  //======  APP
  require('ApiRoutes/appRoutes.php');
  
});