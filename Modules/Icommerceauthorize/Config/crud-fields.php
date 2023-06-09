<?php

return [
    'formFields' => [
        'title' => [
            'value' => null,
            'name' => 'title',
            'type' => 'input',
            'isTranslatable' => true,
            'props' => [
                'label' => 'icommerce::common.title',
            ],
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
            ],
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
                ],
            ],
        ],
        'mainimage' => [
            'value' => (object) [],
            'name' => 'mediasSingle',
            'type' => 'media',
            'props' => [
                'label' => 'Image',
                'zone' => 'mainimage',
                'entity' => "Modules\Icommerce\Entities\PaymentMethod",
                'entityId' => null,
            ],
        ],
        'init' => [
            'value' => 'Modules\Icommerceauthorize\Http\Controllers\Api\IcommerceAuthorizeApiController',
            'name' => 'init',
            'isFakeField' => true,
        ],
        'apiLogin' => [
            'value' => null,
            'name' => 'apiLogin',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommerceauthorize::icommerceauthorizes.table.apiLogin',
            ],
        ],
        'transactionKey' => [
            'value' => null,
            'name' => 'transactionKey',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommerceauthorize::icommerceauthorizes.table.transactionKey',
            ],
        ],
        'clientKey' => [
            'value' => null,
            'name' => 'clientKey',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommerceauthorize::icommerceauthorizes.table.clientKey',
            ],
        ],
        'showInCurrencies' => [
            'value' => ['USD'],
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
                'options' => [
                    ['label' => 'USD', 'value' => 'USD'],
                ],
            ],
        ],
        'mode' => [
            'value' => 'sandbox',
            'name' => 'mode',
            'isFakeField' => true,
            'type' => 'select',
            'props' => [
                'label' => 'icommerceauthorize::icommerceauthorizes.table.mode',
                'useInput' => false,
                'useChips' => false,
                'multiple' => false,
                'hideDropdownIcon' => true,
                'newValueMode' => 'add-unique',
                'options' => [
                    ['label' => 'Sandbox', 'value' => 'sandbox'],
                    ['label' => 'Live', 'value' => 'live'],
                ],
            ],
        ],
        'minimunAmount' => [
            'value' => 0,
            'name' => 'minimunAmount',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommerce::common.minimum Amount',
            ],
        ],
        'maximumAmount' => [
            'value' => null,
            'name' => 'maximumAmount',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommerce::common.formFields.maximum Amount',
            ],
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
                'label' => 'icommerce::common.formFields.excludedUsersForMaximumAmount',
                'multiple' => true,
                'use-chips' => true,
            ],
        ],

    ],

];
