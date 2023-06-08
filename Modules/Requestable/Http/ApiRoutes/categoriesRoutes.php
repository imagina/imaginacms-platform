<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/categories'], function (Router $router) {
 

  $router->get('/{id}/form-fields', [
    'as' => 'categories.form.fields',
    'uses' => 'CategoryApiController@getFormFields',
    'middleware' => ['auth:api','auth-can:requestable.categories.index']
  ]);


  
});