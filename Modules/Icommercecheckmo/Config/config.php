<?php

return [
    'name' => 'Icommercecheckmo',
    'paymentName' => 'icommercecheckmo',
    /*
    * Methods
    */
    'methods' => [
    	// Contraentrega
    	[
    		'title' => 'icommercecheckmo::icommercecheckmos.methods.checkmo.title',
    		'description' => 'icommercecheckmo::icommercecheckmos.methods.checkmo.description',
            'name' => 'icommercecheckmo',
    		'status' => 1,
    	],
    	// Efectivo
    	[
    		'title' => 'icommercecheckmo::icommercecheckmos.methods.cash.title',
    		'description' => 'icommercecheckmo::icommercecheckmos.methods.cash.description',
            'name' => 'icommercecash',
    		'status' => 0,
            'parent_name' => 'icommercecheckmo'
    	],
    	//Daviplata
    	[
    		'title' => 'icommercecheckmo::icommercecheckmos.methods.daviplata.title',
    		'description' => 'icommercecheckmo::icommercecheckmos.methods.daviplata.description',
            'name' => 'icommercedavidplata',
    		'status' => 0,
            'parent_name' => 'icommercecheckmo'
    	],
    	//nequi
    	[
    		'title' => 'icommercecheckmo::icommercecheckmos.methods.nequi.title',
    		'description' => 'icommercecheckmo::icommercecheckmos.methods.nequi.description',
            'name' => 'icommercenequi',
    		'status' => 0,
            'parent_name' => 'icommercecheckmo'
    	],
    	
    ]
];
