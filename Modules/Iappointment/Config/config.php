<?php

return [
    'name' => 'Iappointment',

    'appointmentStatuses' => [
        '1' => [
            'id' => 1,
            'title' => 'iappointment::appointmentstatuses.statuses.pending',
        ],
        '2' => [
            'id' => 2,
            'title' => 'iappointment::appointmentstatuses.statuses.in_progress_pre',
        ],
        '3' => [
            'id' => 3,
            'title' => 'iappointment::appointmentstatuses.statuses.in_progress',
        ],
        '4' => [
            'id' => 4,
            'title' => 'iappointment::appointmentstatuses.statuses.canceled',
        ],
        '5' => [
            'id' => 5,
            'title' => 'iappointment::appointmentstatuses.statuses.expired',
        ],
        '6' => [
            'id' => 6,
            'title' => 'iappointment::appointmentstatuses.statuses.completed',
        ],
    ],
    //DEfine entities allowed to limit with Iplan Module
    'limitableEntities' => [
        [
            'entity' => 'Modules\Iappointment\Entities\Appointment',
            'name' => 'Cita',
            'status' => true,
            'attributes' => [
            ]
        ]
    ],

    //Media Fillables
    'mediaFillable' => [
        'appointment' => [
            'mainimage' => 'single',
            'gallery' => 'multiple'
        ],
        'category' => [
            'mainimage' => 'single',
            'gallery' => 'multiple',
        ]
    ],

];
