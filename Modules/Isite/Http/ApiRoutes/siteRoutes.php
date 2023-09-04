<?php

use Illuminate\Routing\Router;
$namespace = "\Modules\Isite\Http\Controllers\Api";
Route::prefix('/site')->group(function (Router $router) {
    $router->get('/version', [
        'as' => 'api.isite.version',
        'uses' => 'SiteApiController@version',
    ]);
    $router->get('/permissions', [
        'as' => 'api.isite.permissions',
        'uses' => 'SiteApiController@permissions',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/settings', [
        'as' => 'api.isite.index',
        'uses' => 'SiteApiController@index',
    ]);
    $router->post('/cache-clear', [
        'as' => 'api.isite.cache.clear',
        'uses' => 'SiteApiController@cacheClear',
        //'middleware' => ['auth:api']
    ]);

    //Tenant Routes
    Route::prefix('/tenant')->group(function (Router $router) {
        $router->post('/', [
            'as' => 'api.isite.create',
            'uses' => 'SiteApiController@create',
            //'middleware' => ['auth:api']
        ]);
        $router->post('/activate-module', [
            'as' => 'api.isite.activate-module',
            'uses' => 'SiteApiController@activateModule',
            //'middleware' => ['auth:api']
        ]);
        $router->put('/update', [
            'as' => 'api.isite.tenant.update',
            'uses' => 'SiteApiController@tenantUpdate',
        ]);
    });
});
