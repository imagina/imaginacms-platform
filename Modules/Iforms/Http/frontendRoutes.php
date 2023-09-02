<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('iforms')->group(function (Router $router) {
//
//    $router->get('lead', [
//        'as' => 'iforms.lead',
//        'uses' => 'PublicController@store',
//        //'middleware' => config('asgard.blog.config.middleware'),
//    ]);

    $router->get('attachment/{formId}/{leadId}/{fileZone}', [
        'as' => 'iform.lead.attachment',
        'uses' => 'PublicController@getAttachment',
    ]);

    $router->get('view/{formId}', [
        'as' => 'iform.view.form',
        'uses' => 'PublicController@viewForm',
    ]);
    $router->get('external/render/{formId}', [
        'as' => 'iform.js.form',
        'uses' => 'PublicController@renderJsForm',
    ]);
});
