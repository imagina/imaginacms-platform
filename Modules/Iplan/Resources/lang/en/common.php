<?php

return [
    'crudFields' => [
        'url' => 'Plan Link',
    ],
    'settings' => [
        'default-plan-to-new-users' => 'Default plan for new users',
        'enableQr' => 'Enable QR code for users',
        'defaultPageDescription' => 'Default description in plan home page',
        'cumulativePlans' => 'Cumulative Plans',
        'hideDefaultPlanInView' => 'Hide the default plan in the plans view',
        'tenant' => [
            'group' => 'Tenants',
            'tenantWithCentralData' => 'Entities with central data',
            'entities' => [
                'plans' => 'Plans',
            ],
        ],
    ],
    'settingHints' => [
        'default-plan-to-new-users' => 'Select a default plan for new users',
        'cumulativePlans' => 'The limits of the previous plans (if the user already has) will not be deactivated',
    ],
    'messages' => [
        'entity-create-not-allowed' => 'Creating/Updating Not Allowed',
        'user-valid-subscription' => 'El usuario <b>:name</b>, posee al menos una (1) suscripción vigente.',
        'user-not-valid-subscription' => 'Lo sentimos. El usuario <b>:name</b>, no posee en el momento ninguna suscripción vigente.',
    ],
    'planNotFound' => 'Plan not valid',
];
