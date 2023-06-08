<?php

return [
    'name' => 'Icommercepaypal',
    'paymentName' => 'icommercepaypal',
    /*
	* Configurations Paypal Default
    */
    'configurations' => [
    	'http.ConnectionTimeOut'=> 30,
    	'log.LogEnabled' => true,
    	'log.FileName' => storage_path('/logs/paypal.log'),
    	'log.LogLevel' => 'ERROR'
    ],
    /*
    * Configurations Paypal Currencies Basics
    */
    'currencies'=> [
        ['label' => 'BRL','value' => 'BRL'],
        ['label' => 'EUR','value' => 'EUR'],
        ['label' => 'MXN','value' => 'MXN'],
        ['label' => 'USD','value' => 'USD'],
    ]
];
