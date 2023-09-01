<?php

return [
    'usersToNotify' => [
        'name' => 'ibooking::usersToNotify',
        'value' => [],
        'type' => 'select',
        'columns' => 'col-12 col-md-6',
        'loadOptions' => [
            'apiRoute' => 'apiRoutes.quser.users',
            'select' => ['label' => 'email', 'id' => 'id'],
        ],
        'props' => [
            'label' => 'ibooking::common.settings.usersToNotify',
            'multiple' => true,
            'clearable' => true,
        ],
    ],

    'formEmails' => [
        'name' => 'ibooking::formEmails',
        'value' => [],
        'type' => 'select',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'useInput' => true,
            'useChips' => true,
            'multiple' => true,
            'hint' => 'ibooking::common.settingHints.emails',
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'label' => 'ibooking::common.settings.emails',
        ],
    ],

    'reservationStatusDefault' => [
        'value' => '0', // Pending
        'name' => 'ibooking::reservationStatusDefault',
        'type' => 'select',
        'columns' => 'col-6',
        'props' => [
            'label' => 'ibooking::common.settings.reservationStatusDefault',
            'useInput' => false,
            'useChips' => false,
            'multiple' => false,
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'options' => (new Modules\Ibooking\Entities\Status)->convertToSettings(),
        ],
    ],

    'waitingTimeToCancelReservation' => [
        'name' => 'ibooking::waitingTimeToCancelReservation',
        'value' => 10,
        'type' => 'input',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'label' => 'ibooking::common.settings.waitingTimeToCancelReservation',
            'type' => 'number',
        ],
    ],

    //Time Range Filter to math resource availability
    'timeRangeFilter' => [
        'name' => 'ibooking::timeRangeFilter',
        'groupName' => 'timeRangeFilter',
        'isTranslatable' => true,
        'groupTitle' => 'ibooking::settings.groupsLabel.timeRangeFilter',
        'children' => [
            //Morning shift
            'label1' => [
                'name' => 'label1',
                'value' => 'En la mañana',
                'type' => 'input',
                'columns' => 'col-md-4 col-12',
                'props' => [
                    'label' => 'ibooking::settings.settingFields.label',
                ],
            ],
            'startTime1' => [
                'name' => 'startTime1',
                'value' => '00:00:00',
                'type' => 'hour',
                'columns' => 'col-md-4 col-12',
                'props' => [
                    'label' => 'ibooking::settings.settingFields.startTime1',
                ],
            ],
            'endTime1' => [
                'name' => 'endTime1',
                'value' => '11:59:59',
                'type' => 'hour',
                'columns' => 'col-md-4 col-12',
                'props' => [
                    'label' => 'ibooking::settings.settingFields.endTime1',
                ],
            ],

            //Afternoon shift
            'label2' => [
                'name' => 'label2',
                'value' => 'En la tarde',
                'type' => 'input',
                'columns' => 'col-md-4 col-12',
                'props' => [
                    'label' => 'ibooking::settings.settingFields.label',
                ],
            ],
            'startTime2' => [
                'name' => 'startTime2',
                'value' => '12:00:00',
                'type' => 'hour',
                'columns' => 'col-md-4 col-12',
                'props' => [
                    'label' => 'ibooking::settings.settingFields.startTime2',
                ],
            ],
            'endTime2' => [
                'name' => 'endTime2',
                'value' => '23:59:59',
                'type' => 'hour',
                'columns' => 'col-md-4 col-12',
                'props' => [
                    'label' => 'ibooking::settings.settingFields.endTime2',
                ],
            ],

            //first extra shift
            'label3' => [
                'name' => 'label3',
                'value' => '',
                'type' => 'input',
                'columns' => 'col-md-4 col-12',
                'props' => [
                    'label' => 'ibooking::settings.settingFields.label',
                ],
            ],
            'startTime3' => [
                'name' => 'startTime3',
                'value' => null,
                'type' => 'hour',
                'columns' => 'col-md-4 col-12',
                'props' => [
                    'label' => 'ibooking::settings.settingFields.startTime3',
                ],
            ],
            'endTime3' => [
                'name' => 'endTime3',
                'value' => null,
                'type' => 'hour',
                'columns' => 'col-md-4 col-12',
                'props' => [
                    'label' => 'ibooking::settings.settingFields.endTime3',
                ],
            ],
        ],

    ],

    'reservationWithPayment' => [
        'value' => '0',
        'name' => 'ibooking::reservationWithPayment',
        'type' => 'checkbox',
        'props' => [
            'label' => 'ibooking::common.settings.reservationWithPayment',
            'trueValue' => '1',
            'falseValue' => '0',
        ],
    ],
    'createExternalMeeting' => [
        'value' => '0',
        'onlySuperAdmin' => true,
        'name' => 'ibooking::createExternalMeeting',
        'type' => 'checkbox',
        'props' => [
            'label' => 'ibooking::common.settings.createExternalMeeting',
            'trueValue' => '1',
            'falseValue' => '0',
        ],
    ],
    'allowPublicReservation' => [
        'name' => 'ibooking::allowPublicReservation',
        'value' => 1,
        'onlySuperAdmin' => true,
        'type' => 'checkbox',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'label' => 'ibooking::common.settings.allowPublicReservation',
            'trueValue' => '1',
            'falseValue' => '0',
        ],
    ],
];
