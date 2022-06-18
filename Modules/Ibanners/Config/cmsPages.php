<?php

return [
  'admin' => [
    "index" => [
      "permission" => "ibanners.positions.manage",
      "activated" => true,
      "path" => "/banners/index",
      "name" => "qbanner.admin.positions",
      "crud" => "qbanner/_crud/positions",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ibanners.cms.sidebar.adminBanner",
      "icon" => "far fa-newspaper",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "showBanner" => [
      "permission" => "ibanners.banners.index",
      "activated" => true,
      "path" => "/banners/show/:id",
      "name" => "qbanner.admin.positions.show",
      "page" => "qbanner/_pages/admin/positions/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ibanners.cms.sidebar.adminBannerEdit",
      "icon" => "fas fa-image",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "ibanner_cms_admin_index"
        ]
      ]
    ],
    "createBanner" => [
      "permission" => "ibanners.banners.create",
      "activated" => true,
      "path" => "/banners/create/:positionId",
      "name" => "qbanner.admin.banner.create",
      "page" => "qbanner/_pages/admin/banner/create.vue",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ibanners.cms.sidebar.adminIndex",
      "icon" => "fas fa-images",
      "authenticated" => true
    ],
    "updateBanner" => [
      "permission" => "ibanners.banners.update",
      "activated" => true,
      "path" => "/banners/update/:positionId/:id",
      "name" => "qbanner.admin.banner.update",
      "page" => "qbanner/_pages/admin/banner/show.vue",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ibanners.cms.sidebar.adminIndex",
      "icon" => "fas fa-images",
      "authenticated" => true
    ]
  ],
  'panel' => [],
  'main' => [],
];
