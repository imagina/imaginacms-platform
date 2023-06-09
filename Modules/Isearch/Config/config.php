<?php

return [
    'name' => 'Isearch',

    'queries' => [
        'iblog' => true,
        'icommerce' => true,
        'page' => false,
        'iplaces' => false,
        'itourism' => false,
        'iperformer' => false,
    ],
    'route' => 'isearch.search',

    /*Layout Posts - Index */
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
                'class' => 'col-6 col-md-4 col-lg-4',
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
        'imageAspect' => '4/3',
    ],

    /*
|--------------------------------------------------------------------------
| Repositories Data
|--------------------------------------------------------------------------
*/
    'repositories' => [
        ['label' => 'Entradas', 'value' => "Modules\Iblog\Repositories\PostRepository"],
        ['label' => 'Productos', 'value' => "Modules\Icommerce\Repositories\ProductRepository"],
        ['label' => 'Categorias Blog', 'value' => "Modules\Iblog\Repositories\CategoryRepository"],
        ['label' => 'Anuncios', 'value' => "Modules\Iad\Repositories\AdRepository"],
        ['label' => 'Lugares', 'value' => "Modules\Iplaces\Repositories\PlaceRepository"],
        ['label' => 'Páginas', 'value' => "Modules\Page\Repositories\PageRepository"],
        ['label' => 'Organizaciones', 'value' => "Modules\Isite\Repositories\OrganizationRepository"],
        ['label' => 'Todos', 'value' => 'all'],
    ],

    /*
|--------------------------------------------------------------------------
| Filters from Isite -  Index General
|--------------------------------------------------------------------------
*/
    'filters' => [

        'searchRepositories' => [
            'title' => trans('isearch::common.filters.searchRepositories.title'),
            'entityTitle' => trans('isearch::common.filters.searchRepositories.entity title'),
            'name' => 'searchRepositories',
            'classes' => 'col-sm-12 col-lg-12 form-group-select',
            'status' => true,
            'isExpanded' => false,
            'type' => 'select',
            'repository' => 'Modules\Isearch\Repositories\SearchRepository', //Repo Get Data
            'repoMethod' => 'getRepositoriesFromSetting', //Method in Repo to Gsssset Data
            'emitTo' => 'itemsListGetData', // Listener (ItemList) - To emit
            'repoAction' => 'filter', // Query Filter - To emit
            'repoAttribute' => 'repository', // Query Filter - To emit
            'listener' => null,
            'isCollapsable' => false,
            'withTitle' => false,
            'withSubtitle' => true,
            'getDataAfterSelected' => true, //Solo en caso q el 'repoMethod' no sea el getItemsBy
            'defaultSelectedSetting' => 'isearch::repoSearch', // 'setting name' to get the default selected (first request),
            'showFirstOptionSelect' => false, //No muestre la opcion "seleccione etc etc"
        ],

    ],

    /*
|--------------------------------------------------------------------------
| Pagination to the index page
|--------------------------------------------------------------------------
*/
    'pagination' => [
        'show' => true,
        /*
  * Types of pagination:
  *  normal
  *  loadMore
  *  infiniteScroll
  */
        'type' => 'normal',
    ],
];
