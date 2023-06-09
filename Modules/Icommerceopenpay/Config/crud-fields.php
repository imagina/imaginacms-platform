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
            'value' => 'Modules\Icommerceopenpay\Http\Controllers\Api\IcommerceOpenpayApiController',
            'name' => 'init',
            'isFakeField' => true,
        ],
        'merchantId' => [
            'value' => null,
            'name' => 'merchantId',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommerceopenpay::icommerceopenpays.formFields.merchant id',
            ],
        ],
        'publicKey' => [
            'value' => null,
            'name' => 'publicKey',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommerceopenpay::icommerceopenpays.formFields.public key',
            ],
        ],
        'privateKey' => [
            'value' => null,
            'name' => 'privateKey',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommerceopenpay::icommerceopenpays.formFields.private key',
            ],
        ],
        'webhookVerificationCode' => [
            'value' => null,
            'name' => 'webhookVerificationCode',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommerceopenpay::icommerceopenpays.formFields.Webhook Verification Code',
            ],
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
                'options' => [
                    ['label' => 'COP', 'value' => 'COP'],
                ],
            ],
        ],
        'mode' => [
            'value' => 'sandbox',
            'name' => 'mode',
            'isFakeField' => true,
            'type' => 'select',
            'props' => [
                'label' => 'icommerce::common.formFields.mode',
                'useInput' => false,
                'useChips' => false,
                'multiple' => false,
                'hideDropdownIcon' => true,
                'newValueMode' => 'add-unique',
                'options' => [
                    ['label' => 'Sandbox', 'value' => 'sandbox'],
                    ['label' => 'Production', 'value' => 'production'],
                ],
            ],
        ],
        'minimunAmount' => [
            'value' => null,
            'name' => 'minimunAmount',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommerce::common.formFields.minimum Amount',
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
