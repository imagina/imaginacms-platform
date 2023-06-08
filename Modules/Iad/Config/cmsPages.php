<?php
return [
  'admin' => [
    "ads" => [
      "permission" => "iad.ads.manage",
      "activated" => true,
      "path" => "/ad/ads/index",
      "name" => "qad.ads.index",
      "crud" => "qad/_crud/ads",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iad.cms.sidebar.adminAds",
      "icon" => "fas fa-bullhorn",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "adsCreate" => [
      "permission" => "iad.ads.create",
      "activated" => true,
      "path" => "/ad/ads/create",
      "name" => "qad.ads.create",
      "page" => "qad/_pages/admin/ads/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iad.cms.sidebar.adminAdsCreate",
      "icon" => "fas fa-bullhorn",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "iad_cms_admin_ads"
        ],
        "recommendations" => [
          "name" => "addForm"
        ]
      ]
    ],
    "adsUpdate" => [
      "permission" => "iad.ads.edit",
      "activated" => true,
      "path" => "/ad/ads/update/:id",
      "name" => "qad.ads.edit",
      "page" => "qad/_pages/admin/ads/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iad.cms.sidebar.adminAdsUpdate",
      "icon" => "fas fa-bullhorn",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "iad_cms_admin_ads"
        ],
        "recommendations" => [
          "name" => "addForm"
        ]
      ]
    ],
    "categories" => [
      "permission" => "iad.categories.manage",
      "activated" => true,
      "path" => "/ad/categories/index",
      "name" => "qad.categories.index",
      "crud" => "qad/_crud/categories",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iad.cms.sidebar.adminCategories",
      "icon" => "fas fa-layer-group",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "iad_cms_admin_ads"
        ]
      ]
    ],
    "ups" => [
      "permission" => "iad.ups.manage",
      "activated" => true,
      "path" => "/ad/ups/index",
      "name" => "qad.ups.index",
      "crud" => "qad/_crud/ups",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iad.cms.sidebar.adminUps",
      "icon" => "fas fa-arrow-alt-circle-up",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "iad_cms_admin_ads"
        ]
      ]
    ],
    "adUps" => [
      "permission" => "iad.ups.manage",
      "activated" => true,
      "path" => "/ad/ad-ups/index",
      "name" => "qad.adUps.index",
      "crud" => "qad/_crud/adUps",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iad.cms.sidebar.adminAdUps",
      "icon" => "fas fa-chart-line",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "iad_cms_admin_ads"
        ]
      ]
    ]
  ],
  'panel' => [
    "ads" => [
      "permission" => "iad.ads.manage",
      "activated" => true,
      "path" => "/ads",
      "name" => "qad.ads.index",
      "crud" => "qad/_crud/ads",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master",
      "title" => "iad.cms.sidebar.panelAds",
      "icon" => "fas fa-bullhorn",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "adsCreate" => [
      "permission" => "iad.ads.create",
      "activated" => true,
      "path" => "/ads/create",
      "name" => "qad.ads.create",
      "page" => "qad/_pages/admin/ads/form",
      "layout" => "qsite/_layouts/master",
      "title" => "iad.cms.sidebar.adminAdsCreate",
      "icon" => "fas fa-bullhorn",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "iad_cms_panel_ads"
        ],
        "recommendations" => [
          "name" => "addForm"
        ]
      ]
    ],
    "adsUpdate" => [
      "permission" => "iad.ads.edit",
      "activated" => true,
      "path" => "/ads/update/:id",
      "name" => "qad.ads.edit",
      "page" => "qad/_pages/admin/ads/form",
      "layout" => "qsite/_layouts/master",
      "title" => "iad.cms.sidebar.adminAdsUpdate",
      "icon" => "fas fa-bullhorn",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "iad_cms_panel_ads"
        ],
        "recommendations" => [
          "name" => "addForm"
        ]
      ]
    ]
  ],
  'main' => []
];
