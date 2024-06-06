<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => 'iforms'], function (Router $router) {

    $router->get('/lead', [
        'as' => 'iforms.lead',
        'uses' => 'PublicController@store',
        //'middleware' => config('asgard.blog.config.middleware'),
    ]);

});
