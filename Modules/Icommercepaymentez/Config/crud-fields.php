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
            'value' => 'Modules\Icommercepaymentez\Http\Controllers\Api\IcommercePaymentezApiController',
            'name' => 'init',
            'isFakeField' => true,
        ],
        'serverAppCode' => [
            'value' => null,
            'name' => 'serverAppCode',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercepaymentez::icommercepaymentezs.formFields.server App Code',
            ],
        ],
        'serverAppKey' => [
            'value' => null,
            'name' => 'serverAppKey',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercepaymentez::icommercepaymentezs.formFields.server App Key',
            ],
        ],
        'clientAppCode' => [
            'value' => null,
            'name' => 'clientAppCode',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercepaymentez::icommercepaymentezs.formFields.client App Code',
            ],
        ],
        'clientAppKey' => [
            'value' => null,
            'name' => 'clientAppKey',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercepaymentez::icommercepaymentezs.formFields.client App Key',
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
        'type' => [
            'value' => 'checkout',
            'name' => 'type',
            'isFakeField' => true,
            'type' => 'select',
            'props' => [
                'label' => 'icommercepaymentez::icommercepaymentezs.formFields.type',
                'useInput' => false,
                'useChips' => false,
                'multiple' => false,
                'hideDropdownIcon' => true,
                'newValueMode' => 'add-unique',
                'options' => [
                    ['label' => 'Checkout - (Dentro de la misma pagina - Solo Tarjetas)', 'value' => 'checkout'],
                    ['label' => 'Link To Redirect (Reedirige a Paymentez - Es necesario configurar un webhook para la respuesta )', 'value' => 'linkToRedirect'],
                ],
            ],
        ],
        'allowedPaymentMethods' => [
            'value' => [],
            'name' => 'allowedPaymentMethods',
            'isFakeField' => true,
            'type' => 'select',
            'props' => [
                'label' => 'icommercepaymentez::icommercepaymentezs.formFields.allowed payment methods',
                'useChips' => true,
                'multiple' => true,
                'options' => [
                    ['label' => 'All', 'value' => 'All'],
                    ['label' => 'Card', 'value' => 'Card'],
                    ['label' => 'BankTransfer', 'value' => 'BankTransfer'],
                    ['label' => 'Cash', 'value' => 'Cash'],
                    ['label' => 'EWallet', 'value' => 'EWallet'],
                    ['label' => 'Qr', 'value' => 'Qr'],
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
