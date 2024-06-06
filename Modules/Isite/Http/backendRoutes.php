<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/isite'], function (Router $router) {
    $router->bind('site', function ($id) {
        return app('Modules\Isite\Repositories\SiteRepository')->find($id);
    });
    $router->get('sites', [
        'as' => 'admin.isite.site.index',
        'uses' => 'SiteController@index',
        'middleware' => 'can:isite.sites.index'
    ]);
    $router->get('sites/create', [
        'as' => 'admin.isite.site.create',
        'uses' => 'SiteController@create',
        'middleware' => 'can:isite.sites.create'
    ]);
    $router->post('sites', [
        'as' => 'admin.isite.site.store',
        'uses' => 'SiteController@store',
        'middleware' => 'can:isite.sites.create'
    ]);
    $router->get('sites/{site}/edit', [
        'as' => 'admin.isite.site.edit',
        'uses' => 'SiteController@edit',
        'middleware' => 'can:isite.sites.edit'
    ]);
    $router->put('sites/{site}', [
        'as' => 'admin.isite.site.update',
        'uses' => 'SiteController@update',
        'middleware' => 'can:isite.sites.edit'
    ]);
    $router->delete('sites/{site}', [
        'as' => 'admin.isite.site.destroy',
        'uses' => 'SiteController@destroy',
        'middleware' => 'can:isite.sites.destroy'
    ]);
// append

});
