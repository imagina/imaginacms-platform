<?php

return [
    'name' => 'Wishlistable',

    /*
 |--------------------------------------------------------------------------
 | Transformeable config
 | (if they are empty icommerce module will be using default includes) (slim)
 |--------------------------------------------------------------------------
 */
    'transformeable' => [
        'wishlistable' => [
            'product' => [
                'path' => 'Modules\Icommerce\Transformers\ProductTransformer', //this is the transformer path
                'multiple' => false, //if is one-to-many, multiple must be set to true
                'entity' => 'Modules\Icommerce\Entities\Product',
            ],
            'ad' => [
                'path' => 'Modules\Iad\Transformers\AdTransformer', //this is the transformer path
                'multiple' => false, //if is one-to-many, multiple must be set to true
                'entity' => 'Modules\Iad\Entities\Ad',
            ],
        ],
    ],

    /*
|--------------------------------------------------------------------------
| Define the options to the user menu component
|
| @note routeName param must be set without locale. Ex: (icommerce orders: 'icommerce.store.order.index')
| use **onlyShowInTheDropdownHeader** (boolean) if you want the link only appear in the dropdown in the header
| use **onlyShowInTheMenuOfTheIndexProfilePage** (boolean) if you want the link only appear in the dropdown in the header
| use **showInMenuWithoutSession** (boolean) if you want the link only appear in the dropdown when don't exist session
| use **dispatchModal** (string - modalAlias) if you want the link only appear in the dropdown when don't exist session
| use **url** (string) if you want customize the link
|--------------------------------------------------------------------------
*/
    'userMenuLinks' => [

        [
            'title' => 'wishlistable::wishlistables.title.myWishlist',
            'routeName' => 'wishlistable.wishlist.index',
            'icon' => 'fa fa-heart',
        ],
    ],

];
