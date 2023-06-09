<?php

return [
    'single' => 'Stripe',
    'description' => 'The description module',
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
        'description' => 'Descripcion',
        'mode' => 'Mode',
        'publicKey' => 'Public Key',
        'secretKey' => 'Secret Key',
        'accountId' => 'Account Id',
        'signSecret' => 'Sign Secret to Webhook',
        'comisionAmount' => 'Comision Amount',
        'minimunAmount' => 'Minimum Amount ($0.50)',
        'connectCountries' => 'Countries enabled for connect accounts',
        'currency' => 'Currency',
    ],
    'form' => [
    ],
    'formFields' => [

    ],
    'messages' => [
        'accountCreated' => 'Your Connect account has been created',
        'accountAlreadyHave' => 'You already have a Connect account',
        'verifyAccount' => 'You must verify your account details in order to receive payments. For that click on the following link: ',
    ],
    'validation' => [
        'accountIncompletePanelUrl' => 'You must complete the account data verification process to get the panel URL',
        'accountIncomplete' => 'The destination account does not have the requirements to receive payments',
    ],
];
