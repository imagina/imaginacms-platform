<?php

return [
    'name' => 'Iplan',

    //Media Fillables
    'mediaFillable' => [
        'plan' => [
            'mainimage' => 'single',
        ],
    ],

    'subscriptionEntities' => [
        [
            'label' => 'Users',
            'value' => 'Modules\\User\\Entities\\Sentinel\\User',
            'apiRoute' => 'apiRoutes.quser.users',
            'options' => ['label' => 'fullName', 'id' => 'id'],
        ],
        [
            'label' => 'User Groups',
            'value' => 'Modules\\Iprofile\\Entities\\Department',
            'apiRoute' => 'apiRoutes.quser.departments',
            'options' => ['label' => 'title', 'id' => 'id'],
        ],
    ],
    'userMenuLinks' => [
        [
            'title' => 'iplan::common.title.my-subscriptions',
            'routeName' => 'plans.mySubscriptions',
            'icon' => 'fa fa-id-card-o mr-2',

        ],
    ],
    /*Translate keys of each entity. Based on the permission string*/
    'documentation' => [
        'plans' => 'iplan::cms.documentation.plans',
        'limits' => 'iplan::cms.documentation.limits',
        'categories' => 'iplan::cms.documentation.categories',
        'entityplans' => 'iplan::cms.documentation.entityplans',
        'subscriptions' => 'iplan::cms.documentation.subscriptions',
    ],
];
