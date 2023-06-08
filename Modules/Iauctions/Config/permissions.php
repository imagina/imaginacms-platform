<?php

return [
    'iauctions.auctions' => [
        'manage' => 'iauctions::auctions.manage resource',
        'index' => 'iauctions::auctions.list resource',
        'index-all' => 'iauctions::auctions.list resource',
        'create' => 'iauctions::auctions.create resource',
        'edit' => 'iauctions::auctions.edit resource',
        'edit-status' => 'iauctions::auctions.edit resource',
        'destroy' => 'iauctions::auctions.destroy resource',
        'restore' => 'iauctions::auctions.restore resource',
    ],
    'iauctions.categories' => [
        'manage' => 'iauctions::categories.manage resource',
        'index' => 'iauctions::categories.list resource',
        'create' => 'iauctions::categories.create resource',
        'edit' => 'iauctions::categories.edit resource',
        'destroy' => 'iauctions::categories.destroy resource',
        'restore' => 'iauctions::categories.restore resource',
    ],
    'iauctions.bids' => [
        'manage' => 'iauctions::bids.manage resource',
        'index' => 'iauctions::bids.list resource',
        'create' => 'iauctions::bids.create resource',
        'edit' => 'iauctions::bids.edit resource',
        'destroy' => 'iauctions::bids.destroy resource',
        'restore' => 'iauctions::bids.restore resource',
    ],
// append



];
