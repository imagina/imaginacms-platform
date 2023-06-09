<?php

return [
    'idocs.categories' => [
        'manage' => 'idocs::categories.manage list',
        'index' => 'idocs::categories.list resource',
        'index-all' => 'idocs::categories.list resource',
        'create' => 'idocs::categories.create resource',
        'edit' => 'idocs::categories.edit resource',
        'destroy' => 'idocs::categories.destroy resource',
    ],
    'idocs.documents' => [
        'migrate' => 'idocs::documents.migrate',
        'manage' => 'idocs::documents.manage list',
        'index' => 'idocs::documents.list resource',
        'index-all' => 'idocs::documents.list resource',
        'create' => 'idocs::documents.create resource',
        'edit' => 'idocs::documents.edit resource',
        'destroy' => 'idocs::documents.destroy resource',
    ],
    // append

];
