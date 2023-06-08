<?php
$item = (array)json_decode(setting('iblog::arrayItemComponentsAttributesBlog'));
if (!empty($item)) {
    if (!empty($item['orderClasses'])) {
        $item['orderClasses'] = (array)$item['orderClasses'];
    }
} else {
  $item = [
    'withViewMoreButton' => false,
    'withCategory' => false,
    'withSummary' => true,
    'withCreatedDate' => true,
    'layout' => 'item-list-layout-6',
    'imageAspect' => '4/3',
    'imageObject' => 'cover',
    'imageBorderRadio' => '0',
    'imageBorderStyle' => 'solid',
    'imageBorderWidth' => '0',
    'imageBorderColor' => '#000000',
    'imagePadding' => '0',
    'withTitle' => true,
    'titleAlign' => '',
    'titleTextSize' => '18',
    'titleTextWeight' => 'font-weight-bold',
    'titleTextTransform' => '',
    'formatCreatedDate' => 'd/m/Y',
    'summaryAlign' => 'text-justify',
    'summaryTextSize' => '14',
    'summaryTextWeight' => 'font-weight-normal',
    'numberCharactersSummary' => '160',
    'categoryAlign' => 'text-left',
    'categoryTextSize' => '14',
    'categoryTextWeight' => 'font-weight-normal',
    'createdDateAlign' => 'text-left',
    'createdDateTextSize' => '12',
    'createdDateTextWeight' => 'font-weight-normal',
    'buttonAlign' => 'text-left',
    'buttonLayout' => '',
    'buttonIcon' => 'fa fa-angle-right',
    'buttonIconLR' => 'left',
    'buttonColor' => 'dark',
    'viewMoreButtonLabel' => 'iblog::common.layouts.viewMore',
    'withImageOpacity' => 'false',
    'imageOpacityColor' => ' ',
    'imageOpacityDirection' => ' ',
    'orderClasses' => [
      'photo' => 'order-0',
      'title' => 'order-1',
      'date' => 'order-2',
      'categoryTitle' => 'order-4',
      'summary' => 'order-3',
      'viewMoreButton' => 'order-5'
    ],
    'imagePosition' => '1',
    'imagePositionVertical' => 'align-self-center',
    'contentPositionVertical' => 'align-self-center',
    'contentPadding' => '0',
    'contentBorder' => '0',
    'contentBorderColor' => '#ffffff',
    'contentBorderRounded' => '0',
    'contentMarginInsideX' => 'mx-3 mx-md-3 mx-lg-4',
    'contentBorderShadows' => '0 .5rem 1rem rgba(0,0,0,.15)',
    'contentBorderShadowsHover' => '',
    'titleColor' => 'text-dark',
    'summaryColor' => 'text-dark',
    'categoryColor' => 'text-dark',
    'createdDateColor' => 'text-dark',
    'titleMarginT' => 'mt-3 mt-md-3',
    'titleMarginB' => 'mb-2 mb-md-1',
    'summaryMarginT' => 'mt-1 ',
    'summaryMarginB' => 'mb-3',
    'categoryMarginT' => 'mt-1 mt-md-3',
    'categoryMarginB' => 'mb-1 mt-md-2',
    'categoryOrder' => '4',
    'createdDateMarginT' => 'mt-0 mt-md-2',
    'createdDateMarginB' => 'mb-1',
    'createdDateOrder' => '2',
    'buttonMarginT' => 'mt-md-0 mt-4',
    'buttonMarginB' => 'mb-md-2 mb-2',
    'buttonOrder' => '5',
    'titleLetterSpacing' => '0',
    'summaryLetterSpacing' => '0',
    'categoryLetterSpacing' => '0',
    'createdDateLetterSpacing' => '0',
    'titleVineta' => '',
    'titleVinetaColor' => 'text-dark',
    'buttonSize' => 'button-normal',
    'buttonTextSize' => '14',
    'itemBackgroundColor' => '#ffffff',
    'itemBackgroundColorHover' => '#ffffff',
    'titleHeight' => '60',
    'summaryHeight' => '100',
    'titleTextSizeMobile'=>'17',
  ];
}
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

  /*
 |--------------------------------------------------------------------------
 | Define config to the orderBy in the index page
 |--------------------------------------------------------------------------
 */
  'orderBy' => [
    'default' => 'recently',
    'options' => [
      'nameaz' => [
        'title' => 'isite::common.sort.name_a_z',
        'name' => 'nameaz',
        'order' => [
          'field' => "title",
          'way' => "asc",
        ]
      ],
      'nameza' => [
        'title' => 'isite::common.sort.name_z_a',
        'name' => 'nameza',
        'order' => [
          'field' => "name",
          'way' => "desc",
        ]
      ],
      'recently' => [
        'title' => 'isite::common.sort.recently',
        'name' => 'recently',
        'order' => [
          'field' => "created_at",
          'way' => "desc",
        ]
      ]
    ],
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

  /*
|--------------------------------------------------------------------------
| Pagination to the index page
|--------------------------------------------------------------------------
*/
  'pagination' => [
    "show" => true,
    /*
  * Types of pagination:
  *  normal
  *  loadMore
  *  infiniteScroll
  */
    "type" => "normal"
  ],

  /*
|--------------------------------------------------------------------------
| Configuration item layouts show and index
|--------------------------------------------------------------------------
*/
  'itemComponentAttributesBlog' => $item,

  /*
  |--------------------------------------------------------------------------
  | Pages Base
  |--------------------------------------------------------------------------
  */
  'pagesBase' => [
    //Iblog Index
    'blog' => [
      'template' => 'default',
      'is_home' => 0,
      'system_name' => 'blog',
      'type' => 'internal',
      'en' => [
        'title' => 'Blog',
        'slug' => 'blog',
        'body' => '<p>Blog</p>',
        'meta_title' => 'Blog',
      ],
      'es' => [
        'title' => 'Blog',
        'slug' => 'blog',
        'body' => '<p>blog</p>',
        'meta_title' => 'Blog',
      ],
    ],//Iblog Show
    'blog-show' => [
      'template' => 'default',
      'is_home' => 0,
      'system_name' => 'blog-show',
      'type' => 'internal',
      'en' => [
        'title' => 'Blog Show',
        'slug' => 'blog-show',
        'body' => '<p>Blog Show</p>',
        'meta_title' => 'Blog show',
      ],
      'es' => [
        'title' => 'Blog Show',
        'slug' => 'blog-show',
        'body' => '<p>Blog Show</p>',
        'meta_title' => 'Blog Show',
      ],
    ],
  ],

  /*Translate keys of each entity. Based on the permission string*/
  'documentation' => [
    'posts' => "iblog::cms.documentation.posts",
    'categories' => "iblog::cms.documentation.categories",
  ]
];
