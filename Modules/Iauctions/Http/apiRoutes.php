<?php

use Illuminate\Routing\Router;

Route::group(['prefix' =>'/iauctions/v1'], function (Router $router) {
    $router->apiCrud([
        'module' => 'iauctions',
        'prefix' => 'auctions',
        'controller' => 'AuctionApiController',
        //'middleware' => ['update' => ['can:iauctions.auctions.edit-status']]
        'middleware' => ['update' => ['auth-can:iauctions.auctions.edit-status']],
    ]);
    $router->apiCrud([
        'module' => 'iauctions',
        'prefix' => 'categories',
        'controller' => 'CategoryApiController',
        //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
    $router->apiCrud([
        'module' => 'iauctions',
        'prefix' => 'bids',
        'controller' => 'BidApiController',
        //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);

    //Static Class statusBid
    $router->apiCrud([
        'module' => 'iauctions',
        'prefix' => 'status-bid',
        'staticEntity' => "Modules\Iauctions\Entities\StatusBid",
        'use' => ['index' => 'getAllStatus', 'show' => 'get'],
    ]);
    // append
});
