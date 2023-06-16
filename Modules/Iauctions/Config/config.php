<?php

return [

    /*
    * Format to hour - strtotime method
    * Used: Email Notification
    */
    'hourFormat' => 'd-m-Y H:i A',

    /*
    |--------------------------------------------------------------------------
    | Define all the exportable available
    |--------------------------------------------------------------------------
    */
    'exportable' => [
        'bids' => [
            'moduleName' => 'Iauctions',
            'fileName' => 'Bids',
            'exportName' => 'BidsExport',
        ],
    ],

    /*
   |--------------------------------------------------------------------------
   | Define config to the mediaFillable trait for each entity
   |--------------------------------------------------------------------------
   */
    'mediaFillable' => [
        'bid' => [
            'mainimage' => 'single',
        ],
    ],

];
