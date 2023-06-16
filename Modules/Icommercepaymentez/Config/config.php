<?php

return [
    'name' => 'Icommercepaymentez',
    'paymentName' => 'icommercepaymentez',

    /*
    * API URL
    */
    'apiUrl' => [
        'linkToPay' => [
            'sandbox' => 'https://noccapi-stg.paymentez.com/linktopay/init_order/',
            'production' => 'https://noccapi.paymentez.com/linktopay/init_order/',
        ],
    ],

    /*
    *
    */
    'linkToPay' => [
        'expirationTime' => 120, //Seg
    ],

];
