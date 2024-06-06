<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/inline'], function (Router $router) {

    $router->post('/save', [
        'as' => 'inline.save',
        'uses' => 'PublicController@inlinesave',
        //'middleware' => config('asgard.blog.config.middleware'),
    ]);
    // append
});

$router->get('/sitemap', [
  'as' => 'ihelpers.sitemap',
  'uses' => 'PublicController@showSiteMap',
  //'middleware' => config('asgard.blog.config.middleware'),
]);
