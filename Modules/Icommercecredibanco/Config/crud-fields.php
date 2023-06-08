<?php

return [
  'formFields' => [
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
      'type' => 'html',
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
          ['label' => 'Activo', 'value' => 1],
          ['label' => 'Inactivo', 'value' => 0],
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
      'value' => 'Modules\Icommercecredibanco\Http\Controllers\Api\IcommerceCredibancoApiController',
      'name' => 'init',
      'isFakeField' => true
    ],
    'user' => [
      'value' => null,
      'name' => 'user',
      'isFakeField' => true,
      'type' => 'input',
      'props' => [
        'label' => 'icommercecredibanco::icommercecredibancos.table.user'
      ]
    ],
    'password' => [
      'value' => null,
      'name' => 'password',
      'isFakeField' => true,
      'type' => 'input',
      'props' => [
        'label' => 'icommercecredibanco::icommercecredibancos.table.password'
      ]
    ],
    'merchantId' => [
      'value' => null,
      'name' => 'merchantId',
      'isFakeField' => true,
      'type' => 'input',
      'props' => [
        'label' => 'icommercecredibanco::icommercecredibancos.table.merchantId'
      ]
    ],
    'showInCurrencies' => [
      'value' => ['COP'],
      'name' => 'showInCurrencies',
      'isFakeField' => true,
      'type' => 'select',
      'props' => [
        'label' => 'icommerce::paymentmethods.messages.showInCurrencies',
        'useInput' => false,
        'useChips' => false,
        'multiple' => true,
        'hideDropdownIcon' => true,
        'newValueMode' => 'add-unique',
        'options' =>  [
          ['label' => 'COP','value' => 'COP']
        ]
      ]
    ],
    'mode' => [
      'value' => 'sandbox',
      'name' => 'mode',
      'isFakeField' => true,
      'type' => 'select',
      'props' => [
        'label' => 'icommercecredibanco::icommercecredibancos.table.mode',
        'useInput' => false,
        'useChips' => false,
        'multiple' => false,
        'hideDropdownIcon' => true,
        'newValueMode' => 'add-unique',
        'options' => [
          ['label' => 'Sandbox', 'value' => 'sandbox'],
          ['label' => 'Production', 'value' => 'production'],
        ]
      ]
    ],
    'maximumAmount' => [
      'value' => null,
      'name' => 'maximumAmount',
      'isFakeField' => true,
      'type' => 'input',
      'props' => [
        'label' => 'icommercecredibanco::icommercecredibancos.formFields.maximumAmount'
      ]
    ],
  
    'excludedUsersForMaximumAmount' => [
      'name' => 'excludedUsersForMaximumAmount',
      'value' => [],
      'type' => 'select',
      'isFakeField' => true,
      'loadOptions' => [
        'apiRoute' => 'apiRoutes.quser.users',
        'select' => ['label' => 'email', 'id' => 'id'],
      ],
      'props' => [
        'label' => 'icommercecredibanco::icommercecredibancos.formFields.excludedUsersForMaximumAmount',
        'multiple' => true,
        'use-chips' => true,
      ],
    ],
  
  ],


];