<?php

use Illuminate\Routing\Router;

Route::prefix('/provider/conversations')->group(function (Router $router) {
    $router->post('/', [
        'as' => 'api.ichat.provider.manage',
        'uses' => 'ProviderApiController@create',
        'middleware' => ['auth:api'],
    ]);
});

Route::prefix('/provider/{providerName}')->group(function (Router $router) {
    $router->get('/webhook', [
        'as' => 'api.ichat.provider.validate.webhook',
        'uses' => 'ProviderApiController@validateWebhook',
    ]);
    $router->post('/webhook', [
        'as' => 'api.ichat.provider.handle.webhook',
        'uses' => 'ProviderApiController@handleWebhook',
    ]);
});
