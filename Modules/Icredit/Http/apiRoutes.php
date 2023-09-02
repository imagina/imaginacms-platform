<?php

use Illuminate\Routing\Router;

Route::prefix('/icredit/v1')->group(function (Router $router) {
    // Base API Routes
    $router->apiCrud([
        'module' => 'icredit',
        'prefix' => 'credits',
        'controller' => 'CreditApiController',
        //'middleware' =>  ['create' => [],'update' => [],'delete' => [],'restore' => []]
    ]);

    // withdrawalFunds
    $router->post('/withdrawal-funds', [
        'as' => 'icredit.api.credit.withdrawalFunds',
        'uses' => 'CreditApiController@withdrawalFunds',
        'middleware' => ['auth:api'],
    ]);

    //======  PaymentMethod
    require 'ApiRoutes/paymentRoutes.php';
});
