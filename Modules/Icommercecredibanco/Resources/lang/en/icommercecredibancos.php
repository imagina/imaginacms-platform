<?php

return [
    'single' => 'Credibanco',
    'description' => 'The description of Module',
    'list resource' => 'List icommercecredibancos',
    'create resource' => 'Create icommercecredibancos',
    'edit resource' => 'Edit icommercecredibancos',
    'destroy resource' => 'Destroy icommercecredibancos',
    'title' => [
        'icommercecredibancos' => 'IcommerceCredibanco',
        'create icommercecredibanco' => 'Create a icommercecredibanco',
        'edit icommercecredibanco' => 'Edit a icommercecredibanco',
    ],
    'button' => [
        'create icommercecredibanco' => 'Create a icommercecredibanco',
    ],
    'table' => [
        'merchantId' => 'Merchant Id',
        'nroTerminal' => 'Nro Terminal',
        'vec' => 'Vector',
        'mode' => 'Mode',
        'privateCrypto' => 'Private Cryto (site.cifrado.privada.txt)',
        'privateSign' => 'Private Sign (site.firma.privada.txt)',
        'publicCrypto' => 'Public Crypto (LLAVE.VPOS.CRB.CRYPTO.1024.X509.txt)',
        'publicSign' => 'Public Sign (LLAVE.VPOS.CRB.SIGN.1024.X509.txt)',
    ],
    'form' => [
    ],
    'formFields' => [
        'maximumAmount' => 'Maximum Amount',
        'excludedUsersForMaximumAmount' => 'Excluded users for maximum amount',
    ],
    'messages' => [
        'info' => 'Remember to generate the keys and store them safely on the site',
    ],
    'validation' => [
        'maximumAmount' => 'The order total exceed the maximum amount available (:maximumAmount) for this payment method',
    ],
    'statusTransaction' => [
        'approved' => 'Approved',
        'denied' => 'Denied',
    ],
];
