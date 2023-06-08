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

  /*
 |--------------------------------------------------------------------------
 | Define config to the mediaFillable trait for each entity
 |--------------------------------------------------------------------------
 */
  'mediaFillable' => [
    'category' => [
      'mainimage' => 'single',
    ],
    'document' => [
      'file' => 'single',
      'iconimage' => 'single'
    ]
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
  "userMenuLinks" => [
    [
      "title" => "idocs::frontend.myDocuments",
      "routeName" => "idocs.index.private",
      "icon" => "fa fa-folder-open-o",
      "onlyShowInTheMenuOfTheIndexProfilePage" => true
    ],

  ],

  /*Translate keys of each entity. Based on the permission string*/
  'documentation' => [
    'documents' => "idocs::cms.documentation.documents",
    'categories' => "idocs::cms.documentation.categories"
  ]
];
