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
  'orderBy' =>[
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
  

  
];
