<?php

return [
    'iplan.categories' => [
        'manage' => 'iplan::categories.list resource',
        'index' => 'iplan::categories.list resource',
        'create' => 'iplan::categories.create resource',
        'edit' => 'iplan::categories.edit resource',
        'destroy' => 'iplan::categories.destroy resource',
    ],
    'iplan.plans' => [
        'manage' => 'iplan::plans.manage resource',
        'ownPlans' => 'iplan::plans.ownPlans resource',
        'index' => 'iplan::plans.list resource',
        'create' => 'iplan::plans.create resource',
        'edit' => 'iplan::plans.edit resource',
        'destroy' => 'iplan::plans.destroy resource',
        'restore' => 'iplan::plans.restore resource',
    ],
    'iplan.entityplans' => [
        'manage' => 'iplan::entityplans.list resource',
        'index' => 'iplan::entityplans.list resource',
        'create' => 'iplan::entityplans.create resource',
        'edit' => 'iplan::entityplans.edit resource',
        'destroy' => 'iplan::entityplans.destroy resource',
    ],
    'iplan.limits' => [
        'manage' => 'iplan::limits.list resource',
        'index' => 'iplan::limits.list resource',
        'create' => 'iplan::limits.create resource',
        'edit' => 'iplan::limits.edit resource',
        'destroy' => 'iplan::limits.destroy resource',
    ],
    'iplan.subscriptions' => [
        'manage' => 'iplan::subscriptions.list resource',
        'index' => 'iplan::subscriptions.list resource',
        'create' => 'iplan::subscriptions.create resource',
        'edit' => 'iplan::subscriptions.edit resource',
        'destroy' => 'iplan::subscriptions.destroy resource',
    ],
    'iplan.subscriptionlimits' => [
        'manage' => 'iplan::subscriptionlimits.list resource',
        'index' => 'iplan::subscriptionlimits.list resource',
        'create' => 'iplan::subscriptionlimits.create resource',
        'edit' => 'iplan::subscriptionlimits.edit resource',
        'destroy' => 'iplan::subscriptionlimits.destroy resource',
    ],
    // append

];
