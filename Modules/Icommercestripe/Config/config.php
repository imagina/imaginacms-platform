<?php

return [
    'name' => 'Icommercestripe',
    'paymentName' => 'icommercestripe',

/*
   |--------------------------------------------------------------------------
   | Configuration Currencies Crud Field Account Stripe
   |--------------------------------------------------------------------------
*/
    'currencies'=> [
        ['label' => 'USD','value' => 'USD'],
    ],

/*
   |--------------------------------------------------------------------------
   | Configuration to Field User
   |--------------------------------------------------------------------------
*/

   'fieldName' => 'payoutStripeConfig',
/*
   |--------------------------------------------------------------------------
   | Configurations to create account
   |--------------------------------------------------------------------------
*/
    
    /*
    *  https://stripe.com/docs/connect/account-capabilities
    */
    'capabilities' => [
        'transfers' => ['requested' => true]
    ],
    /*
    * https://stripe.com/docs/connect/service-agreement-types
    */
    'tos_acceptance' => [
        'service_agreement' => 'recipient'
    ],

/*
   |--------------------------------------------------------------------------
   | Configurations to credit
   |--------------------------------------------------------------------------
*/
   'creditService' => 'Modules\Icommercestripe\Services\CreditService',
    
];
