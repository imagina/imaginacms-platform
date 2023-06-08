<?php

return [
    'name' => 'Icommercecheckmo',
    'paymentName' => 'icommercecheckmo',
    /*
    * Crud Fields To Frontend
    */
    'crudFields' => [
        'title' => [
            'value' => null,
            'name' => 'title',
            'type' => 'input',
						'isTranslatable' => true,
            'props' => [
                'label' => 'icommerce::common.title'
            ]
        ],
        'description' => [
            'value' => null,
            'name' => 'description',
            'type' => 'input',
						'isTranslatable' => true,
            'props' => [
                'label' => 'icommerce::common.description',
                'type' => 'textarea',
                'rows' => 3,
            ]
        ],
        'status' => [
            'value' => 0,
            'name' => 'status',
            'type' => 'select',
            'props' => [
              'label' => 'icommerce::common.status',
              'useInput' => false,
              'useChips' => false,
              'multiple' => false,
              'hideDropdownIcon' => true,
              'newValueMode' => 'add-unique',
              'options' => [
                ['label' => 'Activo','value' => 1],
                ['label' => 'Inactivo','value' => 0],
              ]
            ]
        ],
        'image' => [
          'value' => (object)[],
          'name' => 'mediasSingle',
          'type' => 'media',
          'props' => [
            'label' => 'Image',
            'zone' => 'image',
            'entity' => "Modules\Icommerce\Entities\PaymentMethod",
            'entityId' => null
          ]
        ],
        'init' => [
            'value' => 'Modules\Icommercecheckmo\Http\Controllers\Api\IcommerceCheckmoApiController',
            'name' => 'init',
            'isFakeField' => true
        ]
    ],
    /*
    * Methods
    */
    'methods' => [
    	// Contraentrega
    	[
    		'title' => 'icommercecheckmo::icommercecheckmos.methods.checkmo.title',
    		'description' => 'icommerceagree::icommerceagrees.methods.checkmo.description',
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
