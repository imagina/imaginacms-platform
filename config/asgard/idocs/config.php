<?php

return [
  'name' => 'Idocs',

  /*
  |--------------------------------------------------------------------------
  | Dynamic fields
  |--------------------------------------------------------------------------
  | Add fields that will be dynamically added to the Post entity based on Bcrud
  | https://laravel-backpack.readme.io/docs/crud-fields
  */
  'fields' => [
    'category' => [
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
    ],
    'documents' => [
      'secondaryImage' => false,
      'identification' => false,
      'key' => false,
      'users' => false,
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
//        'extension' => function ($self) {
//            return $self->belongsTo(PageExtension::class, 'id', 'page_id')->first();
//        }
  ],

  //Media Fillables
  'mediaFillable' => [
    'category' => [
      'mainimage' => 'single',
    ],
    'document' => [
      'file' => 'single',
      'iconimage' => 'single'
    ]
  ]
];
