<?php

return [
    //Media Fillables
    'mediaFillable' => [
        'block' => [
            'internalimage' => 'single',
            'blockbgimage' => 'single',
            'custommainimage' => 'single',
            'customgallery' => 'multiple',
        ],
    ],
    //Url of the iadmin to manage the blocks themes for clients
    'urlEditBlockTheme' => '/iadmin/#/builder/blocks/client/{blockId}',
];
