<?php

return [
    'name' => 'Imeeting',
    'providerName' => 'imeeting',

    /*
    * Providers
    */
    'providers' => [

        /*
        * Provider Zoom
        */
        'zoom' => [
            'name' => 'zoom', // Required
            'apiUrl' => 'https://api.zoom.us/v2/',
            'defaulValuesMeeting' => [
                'topic' => 'Meeting Shedule with User',
                'duration' => 30
            ]
        ]


    ]

    
    
    
];
