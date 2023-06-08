<?php

return [
    'single' => 'Stripe',
    'description' => 'La descripcion del Modulo',
    'list resource' => 'List icommercestripes',
    'create resource' => 'Create icommercestripes',
    'edit resource' => 'Edit icommercestripes',
    'destroy resource' => 'Destroy icommercestripes',
    'title' => [
        'icommercestripes' => 'IcommerceStripe',
        'create icommercestripe' => 'Create a icommercestripe',
        'edit icommercestripe' => 'Edit a icommercestripe',
    ],
    'button' => [
        'create icommercestripe' => 'Create a icommercestripe',
    ],
    'table' => [
        'description' => 'Description',
        'mode' => 'Mode',
        'publicKey' => 'Public Key',
        'secretKey' => 'Secret Key',
        'accountId' => 'Account Id',
        'signSecret' => 'Sign Secret to Webhook',
        'comisionAmount' => 'Monto de la Comision por transaccion (Application Fee Amount)',
        'minimunAmount' => 'Monto Minimo ($0.50 centavos de dolar)',
        'connectCountries' => 'Paises habilitados para cuentas connect',
        'currency' => 'Moneda de la Cuenta Principal',
    ],
    'form' => [
    ],
    'formFields' => [
        
    ],
    'messages' => [
        'accountCreated' => 'Tu cuenta Connect ha sido creada',
        'accountAlreadyHave' => 'Ya tienes una cuenta Connect',
        'verifyAccount' => 'Debes verificar los datos de tu cuenta para poder recibir pagos. Para eso haz click en el siguiente enlace: ',
    ],
    'validation' => [
        'accountIncompletePanelUrl' => 'Debes completar el proceso de verificacion de datos de la cuenta para obtener la URL del panel',
        'accountIncomplete' => 'La cuenta destino no cumple con los requisitos para recibir pagos'
    ]
];
