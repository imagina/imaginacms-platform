<?php

return [
    'name' => 'Iblog',

    'middleware' => [],

    'imageSize' => ['width' => 1024, 'height' => 768, 'quality' => 80],
    'mediumThumbSize' => ['width' => 400, 'height' => 300, 'quality' => 80],
    'smallThumbSize' => ['width' => 100, 'height' => 80, 'quality' => 80],
    'roles' => [
        'editor' => 'admin'
    ],
    /*
     |--------------------------------------------------------------------------
     | Dynamic fields
     |--------------------------------------------------------------------------
     | Add fields that will be dynamically added to the Post entity based on Bcrud
     | https://laravel-backpack.readme.io/docs/crud-fields
     */
    'fields' => [
        'category' => [
            'secondaryImage' => true,
            'partials' => [
                'translatable' => [
                    'create' => [],
                    'edit' => [],
                ],
                'normal' => [
                    'create' => [],
                    'edit' => [],
                ],
            ],
        ],
        'post' => [
            'secondaryImage' => false,
            'partials' => [
                'translatable' => [
                    'create' => [],
                    'edit' => [],
                ],
                'normal' => [
                    'create' => [],
                    'edit' => [],
                ],
            ],
        ]
    ],
    /*
   |--------------------------------------------------------------------------
   | Dynamic relations
   |--------------------------------------------------------------------------
   | Add relations that will be dynamically added to the Post entity
   */
    'relations' => [
        'category'=>[
          /*  'store' => function () {
                return $this->belongsTo(
                    \Modules\Marketplace\Entities\Store::class);
            },*/
        ],
        'post'=>[
           /* 'store' => function () {
                return $this->belongsTo(
                    \Modules\Marketplace\Entities\Store::class);
            },*/
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Fillable user fields
    |--------------------------------------------------------------------------
    | Set the fillable post and category fields, those fields will be mass assigned
    */
    'fillable' => [
       'post'=>[
           'options',
           'category_id',
           'user_id',
           'status',
           'created_at',
           //'store_id'
       ],
        'category'=>[
            'parent_id',
            'options',
            //'store_id'
        ]
    ],
    /*
   |--------------------------------------------------------------------------
   | Iblog Locale Configuration
   |--------------------------------------------------------------------------
   |
   | The localetime determines the default locale that will be used in date formatting inside this Module with (setlocale function):
    http://php.net/setlocale

   |
   */

    'localeTime' => 'es_CO.UTF-8',

    /*
     |--------------------------------------------------------------------------
     | Array of directories to ignore when selecting the template for a Iblog
     |--------------------------------------------------------------------------
     */
    'template-ignored-directories' => [],

    /*
  |--------------------------------------------------------------------------
  | Iblog timezone Configuration
  |--------------------------------------------------------------------------
  |
  | The application locale determines the default locale that will be used
  | by the translation service provider. You are free to set this value
  | to any of the locales which will be supported by the application.
  |
  */

    'dateTimezone' => 'America/Bogota',

    /*
  |--------------------------------------------------------------------------
  | Iblog og:locale Configuration
  |--------------------------------------------------------------------------
  |
  | The application locale determines the default locale that will be used
  | by the translation service provider. You are free to set this value
  | to any of the locales which will be supported by the application.
  |
  */

    'oglocale' => 'es_LA',

    /*
    |--------------------------------------------------------------------------
    | Iblog Watermark Configuration
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    'watermark' => [
        'activated' => false,
        'url' => 'modules/iblog/img/watermark/watermark.png',
        'position' => 'top-left', #top, top-right, left, center, right, bottom-left, bottom, bottom-right
        'x' => 10,
        'y' => 10,
    ],

    'dateFormat' => '%A, %B %d, %Y',

    /*
       |--------------------------------------------------------------------------
       | Iblog feed Configuration
       |--------------------------------------------------------------------------
       |Activates the import, combination and display of RSS and Atom feeds
       |
       |
       */

    'feed' => [
        'activated' => true,
        'postPerFeed' => 20,
        'logo' => ''
    ],

];
