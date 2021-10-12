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
    'category' => [
      /*  'store' => function () {
            return $this->belongsTo(
                \Modules\Marketplace\Entities\Store::class);
        },*/
    ],
    'post' => [
      /* 'store' => function () {
           return $this->belongsTo(
               \Modules\Marketplace\Entities\Store::class);
       },*/
    ],
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
  //Media Fillables
  'mediaFillable' => [
    'post' => [
      'mainimage' => 'single',
      'secondaryimage' => 'single',
      'gallery' => 'multiple',
      'breadcrumbimage' => 'single'
    ],
    'category' => [
      'mainimage' => 'single',
      'secondaryimage' => 'single',
      'iconimage' => 'single',
      'gallery' => 'multiple',
      'breadcrumbimage' => 'single'

    ]
  ],
  

  /*
  |--------------------------------------------------------------------------
  | Define custom middlewares to apply to the all frontend routes
  |--------------------------------------------------------------------------
  | example: 'logged.in' , 'auth.basic', 'throttle'
  */
  'middlewares' => [],
  
  /*Layout Posts - Index */
  'layoutIndex' => [
    'default' => 'three',
    'options' => [
      'four' => [
        'name' => 'three',
        'class' => 'col-6 col-md-4 col-lg-3',
        'icon' => 'fa fa-th-large',
        'status' => true
      ],
      'three' => [
        'name' => 'three',
        'class' => 'col-6 col-md-4 col-lg-4',
        'icon' => 'fa fa-square-o',
        'status' => true
      ],
      'one' => [
        'name' => 'one',
        'class' => 'col-12',
        'icon' => 'fa fa-align-justify',
        'status' => true
      ],
    ]
  ],
  
  "indexItemListAttributes" => [
    'withCreatedDate' => true,
    'withViewMoreButton' => true,
  
  ],
  
  /*
|--------------------------------------------------------------------------
| Filters to the index page
|--------------------------------------------------------------------------
*/
  'filters' => [
    'categories' => [
      'title' => 'iblog::category.plural',
      'name' => 'categories',
      /*
       * Types of Title:
       *  itemSelected
       *  titleOfTheConfig - default
       */
      'typeTitle' => 'titleOfTheConfig',
      /*
       * Types of Modes for render:
       *  allTree - default
       *  allFamilyOfTheSelectedNode (Need NodeTrait implemented - laravel-nestedset package)
       *  onlyLeftAndRightOfTheSelectedNode (Need NodeTrait implemented - laravel-nestedset package)
       */
      'renderMode' => 'allTree',
      'status' => true,
      'isExpanded' => true,
      'type' => 'tree',
      'repository' => 'Modules\Iblog\Repositories\CategoryRepository',
      'entityClass' => 'Modules\Iblog\Entities\Category',
      'params' => ['filter' => ['internal' => false]],
      'emitTo' => null,
      'repoAction' => null,
      'repoAttribute' => null,
      'listener' => null,
      /*
      * Layouts available:
      *  ttys
      *  alnat
       * default - default
      */
      'layout' => 'default',
      'classes' => 'col-12'
    ]
  ],
  
  /*
|--------------------------------------------------------------------------
| Custom Includes Before Filters
|--------------------------------------------------------------------------
*/
  'customIncludesBeforeFilters' => [
  /*
   "iblog.partials.beforeFilter"
  
  */
  ],
  /*
|--------------------------------------------------------------------------
| Custom Includes After Filters
|--------------------------------------------------------------------------
*/
  'customIncludesAfterFilters' => [
    /*
     "iblog.partials.beforeFilter"
    
    */
  ],
  
  /*
|--------------------------------------------------------------------------
| Custom classes to the index cols
|--------------------------------------------------------------------------
*/
  'customClassesToTheIndexCols' => [
    "sidebar" => "col-lg-3",
    "posts" => "col-lg-9",
  ],
];
