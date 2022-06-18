<?php

return [
  'name' => 'Isearch',

  'queries' => [
    'iblog' => true,
    'icommerce' => true,
    'page' => false,
    'iplaces' => false,
    'itourism' => false,
    'iperformer' => false
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
    'withCreatedDate' => false,
    'withViewMoreButton' => true,

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
];
