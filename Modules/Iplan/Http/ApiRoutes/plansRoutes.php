<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => 'plans'], function (Router $router) {
  
  $router->get('/modules', [
    'as' => 'api.iplan.plans.modules',
    'uses' => 'PlanController@modules',
  ]);
  
  $router->get('/frequencies', [
    'as' => 'api.iplan.plans.frequencies',
    'uses' => 'PlanApiController@frequencies',
  ]);
 

});
