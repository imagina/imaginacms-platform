<?php

return [
    'ievent.categories' => [
        'index' => 'ievent::categories.list resource',
        'manage' => 'ievent::categories.manage resource',
        'index-all' => 'ievent::categories.list-all resource',
        'create' => 'ievent::categories.create resource',
        'edit' => 'ievent::categories.edit resource',
        'show' => 'ievent::categories.show resource',
        'destroy' => 'ievent::categories.destroy resource',
    ],
    'ievent.recurrence-days' => [
        'index' => 'ievent::recurrence-days.list resource',
        'create' => 'ievent::recurrence-days.create resource',
        'edit' => 'ievent::recurrence-days.edit resource',
        'destroy' => 'ievent::recurrence-days.destroy resource',
    ],
    'ievent.events' => [
        'index' => 'ievent::events.list resource',
        'manage' => 'ievent::events.manage resource',
        'index-all' => 'ievent::events.list-all resource',
        'show' => 'ievent::events.show resource',
        'create' => 'ievent::events.create resource',
        'edit' => 'ievent::events.edit resource',
        'destroy' => 'ievent::events.destroy resource',
    ],
    'ievent.recurrences' => [
        'index' => 'ievent::recurrences.list resource',
        'index-all' => 'ievent::recurrences.list-all resource',
        'create' => 'ievent::recurrences.create resource',
        'edit' => 'ievent::recurrences.edit resource',
        'show' => 'ievent::recurrences.show resource',
        'destroy' => 'ievent::recurrences.destroy resource',
    ],
    'ievent.attendants' => [
        'index' => 'ievent::attendants.list resource',
        'manage' => 'ievent::attendants.manage resource',
        'index-all' => 'ievent::attendants.list-all resource',
        'create' => 'ievent::attendants.create resource',
        'edit' => 'ievent::attendants.edit resource',
        'show' => 'ievent::attendants.show resource',
        'destroy' => 'ievent::attendants.destroy resource',
    ],
    'ievent.comments' => [
        'index' => 'ievent::comments.list resource',
        'create' => 'ievent::comments.create resource',
        'edit' => 'ievent::comments.edit resource',
        'destroy' => 'ievent::comments.destroy resource',
    ],
// append

];
