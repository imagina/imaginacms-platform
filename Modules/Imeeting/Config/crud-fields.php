<?php

return [
	/*============= ZOOM PROVIDER =============*/
   'zoom' => [
   		'formFields' => [
	        'title' => [
	            'value' => null,
	            'name' => 'title',
	            'type' => 'input',
	            'isTranslatable' => true,
	            'props' => [
	               'label' => 'imeeting::common.title'
	            ]
	        ],
	        'description' => [
	            'value' => null,
	            'name' => 'description',
	            'type' => 'input',
	            'isTranslatable' => true,
	            'props' => [
	                'label' => 'imeeting::common.description',
	                'type' => 'textarea',
	                'rows' => 3,
	            ]
	        ],
	        'status' => [
	            'value' => 0,
	            'name' => 'status',
	            'type' => 'select',
	            'props' => [
	                'label' => 'imeeting::common.status',
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
	        'mainimage' => [
	            'value' => (object)[],
	            'name' => 'mediasSingle',
	            'type' => 'media',
	            'props' => [
	                'label' => 'Image',
	                'zone' => 'mainimage',
	                'entity' => "Modules\Imeeting\Entities\Provider",
	                'entityId' => null
	            ]
	        ],
	        'apiKey' => [
		        'value' => null,
		        'name' => 'apiKey',
		       	'isFakeField' => true,
		        'type' => 'input',
		        'props' => [
		            'label' => 'imeeting::providers.zoom.apiKey'
		       ]
		    ],
		    'apiSecret' => [
		        'value' => null,
		        'name' => 'apiSecret',
		       	'isFakeField' => true,
		        'type' => 'input',
		        'props' => [
		            'label' => 'imeeting::providers.zoom.apiSecret'
		       ]
		    ],
	        
    	]
    ]	
];