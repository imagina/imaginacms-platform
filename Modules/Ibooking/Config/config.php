<?php

return [
    'name' => 'Ibooking',

    //Media Fillables
    'mediaFillable' => [
        'category' => [
            'mainimage' => 'single',
        ],
        'service' => [
            'mainimage' => 'single',
        ],
        'resource' => [
            'mainimage' => 'single',
        ],
    ],

    /*
  * Format to hour - strtotime method
  * Used: Email
  */
    'hourFormat' => 'd-m-Y H:i A',

    /*
  *
  * Config to Activities in Igamification Module
  */
    'activities' => [
        [
            'system_name' => 'availability-organize',
            'title' => 'ibooking::activities.availability-organize.title',
            'status' => 1,
            'url' => 'ipanel/#/booking/resource/user/',
        ],
        [
            'system_name' => 'availability-reservations',
            'title' => 'ibooking::activities.availability-reservations.title',
            'status' => 1,
            'url' => 'ipanel/#/booking/reservations/index',
        ],
        [
            'system_name' => 'availability-new-reservation',
            'title' => 'ibooking::activities.availability-new-reservation.title',
            'status' => 1,
            'url' => 'ipanel/#/booking/reservations/create',
        ],
    ],

    /*Translate keys of each entity. Based on the permission string*/
    'documentation' => [
        'categories' => 'ibooking::cms.documentation.categories',
        'services' => 'ibooking::cms.documentation.services',
        'resources' => 'ibooking::cms.documentation.resources',
        'reservations' => 'ibooking::cms.documentation.reservations',
    ],
];
