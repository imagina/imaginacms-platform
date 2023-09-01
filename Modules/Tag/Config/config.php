<?php

return [
    'name' => 'Tag',

    /*
  |--------------------------------------------------------------------------
  | Custom Sidebar Class
  |--------------------------------------------------------------------------
  | If you want to customise the admin sidebar ordering or grouping
  | You can define your own sidebar class for this module.
  | No custom sidebar: null
  */
    'custom-sidebar' => null,

    /*
  |--------------------------------------------------------------------------
  | Load additional view namespaces for a module
  |--------------------------------------------------------------------------
  | You can specify place from which you would like to use module views.
  | You can use any combination, but generally it's advisable to add only one,
  | extra view namespace.
  | By default every extra namespace will be set to false.
  */
    'useViewNamespaces' => [
        // Read module views from /Themes/<backend-theme-name>/views/modules/<module-name>
        'backend-theme' => false,
        // Read module views from /Themes/<frontend-theme-name>/views/modules/<module-name>
        'frontend-theme' => false,
        // Read module views from /resources/views/asgard/<module-name>
        'resources' => false,
    ],

    /*
 |--------------------------------------------------------------------------
 | Define custom middlewares to apply to the all frontend routes
 |--------------------------------------------------------------------------
 | example: 'logged.in' , 'auth.basic', 'throttle'
 */
    'middlewares' => [],

    /*
   * Define repositories by Entities
   */
    'repositoriesEntities' => [
        'Modules\Iblog\Entities\Post' => 'Modules\Iblog\Repositories\PostRepository',
        'Modules\Iblog\Entities\Category' => 'Modules\Iblog\Repositories\CategoryRepository',
        'Modules\Page\Entities\Page' => 'Modules\Page\Repositories\PageRepository',
        'Modules\Iplaces\Entities\Place' => 'Modules\Iplaces\Repositories\PlaceRepository',
        'Modules\Icommerce\Entities\Product' => 'Modules\Icommerce\Repositories\ProductRepository',
    ],

    /*
   * Layout Tags - Index
   */
    'layoutIndex' => [
        'default' => 'four',
        'options' => [
            'four' => [
                'name' => 'four',
                'class' => 'col-6 col-md-4 col-lg-3',
                'icon' => 'fa fa-th-large',
                'status' => true,
            ],
            'three' => [
                'name' => 'three',
                'class' => 'col-md-6 col-lg-4',
                'icon' => 'fa fa-square-o',
                'status' => true,
            ],
            'one' => [
                'name' => 'one',
                'class' => 'col-12',
                'icon' => 'fa fa-align-justify',
                'status' => true,
            ],
        ],
    ],
    /*
   * Layout Tags - Attributes
   */
    'indexItemListAttributes' => [
        'layout' => 'item-list-layout-6',
        'withCreatedDate' => false,
        'withViewMoreButton' => true,
        'withSummary' => false,
        'buttonSize' => 'button-small',
        'buttonLayout' => 'rounded',
        'buttonTextSize' => 14,
        'titleTextTransform' => 'text-uppercase',
        'titleTextWeight' => 'font-weight-normal',
        'titleHeight' => 50,
        'titleMarginB' => 'mb-2',
        'titleAlignVertical' => 'align-items-start',
        'numberCharactersTitle' => 40,
    ],
    /*
   * Define repositories by Entities
   */
    'buttonTag' => [
        'Modules\Iblog\Entities\Category' => 'Modules\Iblog\Repositories\CategoryRepository',
        'Modules\Page\Entities\Page' => 'Modules\Page\Repositories\PageRepository',
        'Modules\Iplaces\Entities\Place' => 'Modules\Iplaces\Repositories\PlaceRepository',
        'Modules\Icommerce\Entities\Product' => 'Modules\Icommerce\Repositories\ProductRepository',
    ],

];
