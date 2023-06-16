<?php

return [
    'ibooking.categories' => [
        'index' => 'ibooking::categories.list resource',
        'create' => 'ibooking::categories.create resource',
        'edit' => 'ibooking::categories.edit resource',
        'destroy' => 'ibooking::categories.destroy resource',
        'manage' => 'ibooking::categories.manage resource',
        'restore' => 'ibooking::categories.restore resource',
    ],
    'ibooking.services' => [
        'index' => 'ibooking::services.list resource',
        'create' => 'ibooking::services.create resource',
        'edit' => 'ibooking::services.edit resource',
        'destroy' => 'ibooking::services.destroy resource',
        'manage' => 'ibooking::services.manage resource',
        'restore' => 'ibooking::services.restore resource',
    ],
    'ibooking.resources' => [
        'index' => 'ibooking::resources.list resource',
        'create' => 'ibooking::resources.create resource',
        'edit' => 'ibooking::resources.edit resource',
        'destroy' => 'ibooking::resources.destroy resource',
        'manage' => 'ibooking::resources.manage resource',
        'restore' => 'ibooking::resources.restore resource',
    ],
    'ibooking.reservations' => [
        'index' => 'ibooking::reservations.list resource',
        'index-all' => 'ibooking::reservations.list-all resource',
        'create' => 'ibooking::reservations.create resource',
        'edit' => 'ibooking::reservations.edit resource',
        'destroy' => 'ibooking::reservations.destroy resource',
        'manage' => 'ibooking::reservations.manage resource',
        'restore' => 'ibooking::reservations.restore resource',
    ],
    'ibooking.reservationitems' => [
        'index' => 'ibooking::reservationitems.list resource',
        'create' => 'ibooking::reservationitems.create resource',
        'edit' => 'ibooking::reservationitems.edit resource',
        'destroy' => 'ibooking::reservationitems.destroy resource',
        'manage' => 'ibooking::reservationitems.manage resource',
        'restore' => 'ibooking::reservationitems.restore resource',
    ],
    // append

];
