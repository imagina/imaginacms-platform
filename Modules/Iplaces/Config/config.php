<?php

return [
  'name' => 'Iplaces',
  'imagesize' => ['width' => 1024, 'height' => 768],
  'mediumthumbsize' => ['width' => 400, 'height' => 300],
  'smallthumbsize' => ['width' => 100, 'height' => 80],
  //Media Fillables
  'mediaFillable' => [
    'place' => [
      'mainimage' => 'single',
      'gallery' => 'multiple',
      'breadcrumbimage' => 'single'
    ],
    'category' => [
      'mainimage' => 'single',
      'breadcrumbimage' => 'single',
      'gallery' => 'multiple'
    ],
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
      'title' => 'iplace::category.plural',
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
      'repository' => 'Modules\Iplaces\Repositories\CategoryRepository',
      'entityClass' => 'Modules\Iplaces\Entities\Category',
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

  /*Translate keys of each entity. Based on the permission string*/
  'documentation' => [
    'places' => "iplaces::cms.documentation.places",
    'categories' => "iplaces::cms.documentation.categories"
  ]
];
