<?php

return [
    'name' => 'Icommerceagree',
    'shippingName' => 'icommerceagree',
    /*
    * Methods
    */
    'methods' => [
        // A convenir
        [
            'title' => 'icommerceagree::icommerceagrees.methods.agree.title',
            'description' => 'icommerceagree::icommerceagrees.methods.agree.description',
            'name' => 'icommerceagree',
            'status' => 1,
        ],
        // Retiro en Tienda
        [
            'title' => 'icommerceagree::icommerceagrees.methods.pickup.title',
            'description' => 'icommerceagree::icommerceagrees.methods.pickup.description',
            'name' => 'icommercepickup',
            'status' => 0,
            'parent_name' => 'icommerceagree',
        ],

    ],

];
