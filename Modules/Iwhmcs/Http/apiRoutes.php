<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'iwhmcs/v1'], function (Router $router) {
  //Route sync cients to bitrix
  $router->get('/sync-clients-bitrix24', [
    'as' => 'api.iwhmcs.sync.cients.bitrix',
    'uses' => 'WhmcsApiController@syncClientsToBitrix24',
    'middleware' => ['auth:api']
  ]);
  //Route Sync products
  $router->get('/sync-projects-as-hosting', [
    'as' => 'api.iwhmcs.sync.projects.as.hostings',
    'uses' => 'WhmcsApiController@syncProjectsAsHosting',
    'middleware' => ['auth:api']
  ]);
  //Set group Clients
  $router->get('/set-group-clients', [
    'as' => 'api.iwhmcs.sync.set.group.clients',
    'uses' => 'WhmcsApiController@SetGroupClients',
    'middleware' => ['auth:api']
  ]);
  //Set user to invoice items
  $router->get('/set-client-to-invoice', [
    'as' => 'api.iwhmcs.sync.set.client.to.invoice',
    'uses' => 'WhmcsApiController@setClientToInvoice',
    'middleware' => ['auth:api']
  ]);
  //Route sync cients to bitrix
  $router->get('/sync-products-bitrix24', [
    'as' => 'api.iwhmcs.sync.products.bitrix',
    'uses' => 'WhmcsApiController@syncProductsToBitrix24',
    'middleware' => ['auth:api']
  ]);
  //Route sync cients to bitrix
  $router->get('/sync-invoices-bitrix24', [
    'as' => 'api.iwhmcs.sync.invoices.bitrix',
    'uses' => 'WhmcsApiController@syncInvoicesToBitrix24',
    'middleware' => ['auth:api']
  ]);
  //Validate Weygo deals after get client information
  $router->post('/weygo-deal-data-received', [
    'as' => 'api.iwhmcs.weygo.deal.data.received',
    'uses' => 'WhmcsApiController@weygoDealDataReceived',
    'middleware' => ['auth:api']
  ]);
});

