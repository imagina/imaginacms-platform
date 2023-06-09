<?php

return [
    'icheckin.jobs' => [
        'index' => 'icheckin::jobs.list resource',
        'manage' => 'icheckin::approvals.manage resource',
        'create' => 'icheckin::jobs.create resource',
        'edit' => 'icheckin::jobs.edit resource',
        'destroy' => 'icheckin::jobs.destroy resource',
    ],
    'icheckin.requests' => [
        'index' => 'icheckin::requests.list resource',
        'manage' => 'icheckin::approvals.manage resource',
        'create' => 'icheckin::requests.create resource',
        'edit' => 'icheckin::requests.edit resource',
        'destroy' => 'icheckin::requests.destroy resource',
    ],
    'icheckin.shifts' => [
        'index' => 'icheckin::shifts.list resource',
        'index-all' => 'icheckin::shifts.list resource',
        'manage' => 'icheckin::shifts.manage resource',
        'create' => 'icheckin::shifts.create resource',
        'edit' => 'icheckin::shifts.edit resource',
        'show' => 'icheckin::shifts.show resource',
        'checkin' => 'icheckin::shifts.checkin resource',
        'checkout' => 'icheckin::shifts.checkout resource',
        'destroy' => 'icheckin::shifts.destroy resource',
    ],
    'icheckin.approvals' => [
        'index' => 'icheckin::approvals.list resource',
        'manage' => 'icheckin::approvals.manage resource',
        'create' => 'icheckin::approvals.create resource',
        'edit' => 'icheckin::approvals.edit resource',
        'destroy' => 'icheckin::approvals.destroy resource',
    ],
    // append

];
