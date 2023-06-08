<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'icommercestripe/v1'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'icommercestripe.api.stripe.init',
        'uses' => 'IcommerceStripeApiController@init',
    ]);
    
    $router->post('/response', [
        'as' => 'icommercestripe.api.stripe.response',
        'uses' => 'IcommerceStripeApiController@response',
    ]);


    /*
    * Connect Routes
    */
    $router->group(['prefix' => 'payout/connect'], function (Router $router) {

        $router->post('/', [
            'as' => 'icommercestripe.api.stripe.connect.createAccountLinkOnboarding',
            'uses' => 'IcommerceStripeApiController@connectCreateAccountLinkOnboarding',
            'middleware' => ['auth:api']
        ]);

        $router->get('/account/user', [
            'as' => 'icommercestripe.api.stripe.connect.getAccount',
            'uses' => 'IcommerceStripeApiController@connectGetAccount',
            'middleware' => ['auth:api']
        ]);

        /*
        * Others Testing Stripes Routes
        */
        $router->post('/account-response', [
            'as' => 'icommercestripe.api.stripe.connect.accountResponse',
            'uses' => 'IcommerceStripeApiController@connectAccountResponse',
            'middleware' => ['auth:api']
        ]);

        $router->post('/create-login-link', [
            'as' => 'icommercestripe.api.stripe.connect.CreateLoginLink',
            'uses' => 'IcommerceStripeApiController@connectCreateLoginLink',
            'middleware' => ['auth:api']
        ]);

        $router->get('/country/get', [
            'as' => 'icommercestripe.api.stripe.connect.getCountry',
            'uses' => 'IcommerceStripeApiController@connectGetCountry',
            'middleware' => ['auth:api']
        ]);

        $router->get('/transfer', [
            'as' => 'icommercestripe.api.stripe.connect.connectGetTransfer',
            'uses' => 'IcommerceStripeApiController@connectGetTransfer',
            'middleware' => ['auth:api']
        ]);

        $router->get('/balance-transaction', [
            'as' => 'icommercestripe.api.stripe.connect.connectGetBalanceTransaction',
            'uses' => 'IcommerceStripeApiController@connectGetBalanceTransaction',
            'middleware' => ['auth:api']
        ]);

    });
   

});