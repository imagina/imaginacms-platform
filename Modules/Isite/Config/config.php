<?php

return [
  'name' => 'Isite',

  /*
  |--------------------------------------------------------------------------
  | Livewire Alerts - Config
  |--------------------------------------------------------------------------
  | Default config to the Livewire Alerts
  */
  'livewireAlerts' => [
    'position' => 'top-end',
    "timer" => 5000,
    "timerProgressBar" => true
  ],

  /*
 |--------------------------------------------------------------------------
 | Order By - Index
 |--------------------------------------------------------------------------
 | Default orderBy config to the items List Livewire component
 */
  'orderBy' => [
    'default' => 'recently',
    'options' => [
      'nameaz' => [
        'title' => 'isite::common.sort.name_a_z',
        'name' => 'nameaz',
        'order' => [
          'field' => "name",
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

  /*
  |--------------------------------------------------------------------------
  | Layout Items - Index
  |--------------------------------------------------------------------------
  | Default layout config to the items List Livewire component
  */
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

  /*Layout Posts itemTabs - Index */
  'layoutIndexItemTabs' => [
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

  "indexItemListAttributesItemTabs" => [
    'withCreatedDate' => true,
    'withViewMoreButton' => true,

  ],

  /*
  |--------------------------------------------------------------------------
  | Define config to the mediaFillable trait for each entity
  |--------------------------------------------------------------------------
  */
  "mediaFillable" => [
    'organization' => [
      'mainimage' => 'single',
      'secondaryimage' => 'single',
      'gallery' => 'multiple',
    ],
    'layout' => [
      'mainimage' => 'single',
      'gallery' => 'multiple',
    ],
  ],

  "settingGroups" => [
    'general' => [
      'icon' => 'far fa-edit',
      'title' => 'isite::common.settingGroups.general.title',
      'description' => 'isite::common.settingGroups.general.description'
    ],
    'media' => [
      'icon' => 'far fa-images',
      'title' => 'isite::common.settingGroups.media.title',
      'description' => 'isite::common.settingGroups.media.description'
    ],
    'colors' => [
      'icon' => 'fas fa-tint',
      'title' => 'isite::common.settingGroups.colors.title',
      'description' => 'isite::common.settingGroups.colors.description'
    ],
    'socialNetworks' => [
      'icon' => 'fas fa-thumbs-up',
      'title' => 'isite::common.settingGroups.socialNetworks.title',
      'description' => 'isite::common.settingGroups.socialNetworks.description'
    ],
    'apiKeys' => [
      'icon' => 'fas fa-code',
      'title' => 'isite::common.settingGroups.apiKeys.title',
      'description' => 'isite::common.settingGroups.apiKeys.description'
    ],
    'contact' => [
      'icon' => 'fas fa-phone',
      'title' => 'isite::common.settingGroups.contact.title',
      'description' => 'isite::common.settingGroups.contact.description'
    ],
    'customSources' => [
      'icon' => 'fas fa-pencil-ruler',
      'title' => 'isite::common.settingGroups.customSources.title',
      'description' => 'isite::common.settingGroups.customSources.description'
    ],
    'tenants' => [
      'icon' => 'fas fa-user-friends',
      'title' => 'isite::common.settingGroups.tenants.title',
      'description' => 'isite::common.settingGroups.tenants.description'
    ],
    'modalVerifier' => [
      'icon' => 'fas fa-spell-check',
      'title' => 'isite::common.settingGroups.modalVerifier.title',
      'description' => 'isite::common.settingGroups.modalVerifier.description'
    ],
    'pdf' => [
      'icon' => 'fas fa-file-pdf',
      'title' => 'isite::common.settingGroups.pdf.title',
      'description' => 'isite::common.settingGroups.pdf.description'
    ],
    'maps' => [
      'icon' => 'fas fa-map-marker-alt',
      'title' => 'isite::common.settingGroups.maps.title',
      'description' => 'isite::common.settingGroups.maps.description'
    ],
  ],

  /*
  |--------------------------------------------------------------------------
  | Define config to list layout 4
  |--------------------------------------------------------------------------
  */
  "indexItemListAttributesMain" => [
    'withCreatedDate' => true,
    'withSummary' => false,
    'layout' => 'item-list-layout-6',
    'imageAspect' => '4/3',
    'titleColor' => 'text-dark',
    'createdDateColor' => 'text-light',
    'formatCreatedDate' => 'd \d\e M, Y',
    'titleHeight' => 'auto',
  ],
  "indexItemListAttributesList" => [
    'withCreatedDate' => true,
    'withSummary' => false,
    'layout' => 'item-list-layout-7',
    'imageAspect' => '16/9',
    'imagePosition' => '3',
    'summaryTextSize' => '14',
    'titleHeight' => 'auto',
    'titleColor' => 'text-dark',
    'createdDateColor' => 'text-light',
    'formatCreatedDate' => 'd \d\e M, Y',
    'titleTextSize' => 18,
    'contentPositionVertical' => 'align-self-start'
  ],

  /*
  |--------------------------------------------------------------------------
  | Define config to organizations
  |--------------------------------------------------------------------------
  */

  'organizations' => [

    'layoutIndex' => [
      'default' => 'three',
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
      'withViewMoreButton' => false,
      'withCategory' => false,
      'withSummary' => false,
      'withCreatedDate' => false,
      'layout' => 'item-list-layout-6'
    ]

  ],


  /*
   |--------------------------------------------------------------------------
   | Define format money
   |--------------------------------------------------------------------------
   */
  'siteFormatmoney' => [
    'decimals' => 0,
    'dec_point' => '',
    'housands_sep' => '.'
  ],

  /*
  |--------------------------------------------------------------------------
  | Define ips allowed to middleware CheckIp
  |--------------------------------------------------------------------------
  */
  'ipsAllowed' => [
    //'xxx.xx.xx.xx'
  ],
  'documentation' => [
    'settings' => "isite::cms.documentation.settings",
  ],

  /*
   |--------------------------------------------------------------------------
   | Define format money to the money in sites without icommerce
   |--------------------------------------------------------------------------
   */
  'isiteFormatMoney' => [
    'symbol_left' => '$',
    'symbol_right' => '',
    'decimals' => 0,
    'decimal_separator' => '.',
    'thousands_separator' => ',',
    'code' => 'USD',
    'value' => 1
  ],
];
