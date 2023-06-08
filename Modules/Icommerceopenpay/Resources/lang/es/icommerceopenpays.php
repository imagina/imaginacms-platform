<?php

return [
    'single' => 'Openpay',
    'description' => 'La descripcion del Modulo',
    'list resource' => 'List icommerceopenpays',
    'create resource' => 'Create icommerceopenpays',
    'edit resource' => 'Edit icommerceopenpays',
    'destroy resource' => 'Destroy icommerceopenpays',
    'title' => [
        'icommerceopenpays' => 'IcommerceOpenpay',
        'create icommerceopenpay' => 'Create a icommerceopenpay',
        'edit icommerceopenpay' => 'Edit a icommerceopenpay',
    ],
    'button' => [
        'create icommerceopenpay' => 'Create a icommerceopenpay',
    ],
    'table' => [
        'description' => 'Description',
        'mode' => 'Mode',
    ],
    'form' => [
        'select payment mode' => 'Seleccione el modo en que desea pagar'
    ],
    'formFields' => [
        'merchant id' => 'Merchant Id',
        'public key' => 'Public Key',
        'private key' => 'Private Key',  
        'Webhook Verification Code' => 'Codigo de Verificación para Webhooks'
    ],
    'formHints' => [
        'Webhook Verification Code' => 'Cuando se agregue la URL del webhook en el panel de Openpay, se generará este codigo el cual lo necesitaras para realizar la verificación',
    ],
    'messages' => [
    ],
    'validation' => [
    ]
];
