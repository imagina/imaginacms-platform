<?php

return [
  'admin' => [
    "countries" => [
      "permission" => "ilocations.countries.manage",
      "activated" => true,
      "path" => "/locations/countries",
      "name" => "qlocations.admin.countries.index",
      "crud" => "qlocations/_crud/countries",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ilocations.cms.sidebar.adminCountries",
      "icon" => "fas fa-globe-americas",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "provinces" => [
      "permission" => "ilocations.provinces.manage",
      "activated" => true,
      "path" => "/locations/provinces",
      "name" => "qlocations.admin.provinces.index",
      "crud" => "qlocations/_crud/provinces",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ilocations.cms.sidebar.adminProvinces",
      "icon" => "fas fa-globe-americas",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "cities" => [
      "permission" => "ilocations.cities.manage",
      "activated" => true,
      "path" => "/locations/cities",
      "name" => "qlocations.admin.cities.index",
      "crud" => "qlocations/_crud/cities",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ilocations.cms.sidebar.adminCities",
      "icon" => "fas fa-building",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "cityCreate" => [
      "permission" => null,
      "activated" => true,
      "path" => "/locations/cities/create",
      "name" => "qlocations.admin.cities.create",
      "page" => "qlocations/_pages/admin/cities/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ilocations.cms.sidebar.adminCityCreate",
      "icon" => "fas fa-building",
      "authenticated" => true,
      "subHeader" => [
        "breadcrumb" => [
          "ilocations_cms_admin_cities"
        ]
      ]
    ],
    "cityEdit" => [
      "permission" => null,
      "activated" => true,
      "path" => "/locations/cities/:id",
      "name" => "qlocations.admin.cities.edit",
      "page" => "qlocations/_pages/admin/cities/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ilocations.cms.sidebar.adminCityEdit",
      "icon" => "fas fa-building",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "ilocations_cms_admin_cities"
        ]
      ]
    ],
    "polygons" => [
      "permission" => "ilocations.polygons.manage",
      "activated" => true,
      "path" => "/locations/polygons",
      "name" => "qlocations.admin.polygons.index",
      "crud" => "qlocations/_crud/polygons",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ilocations.cms.sidebar.adminPolygons",
      "icon" => "fas fa-draw-polygon",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "polygonCreate" => [
      "permission" => null,
      "activated" => true,
      "path" => "/locations/polygons/create",
      "name" => "qlocations.admin.polygons.create",
      "page" => "qlocations/_pages/admin/polygons/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ilocations.cms.sidebar.adminPolygonCreate",
      "icon" => "fas fa-draw-polygon",
      "authenticated" => true,
      "subHeader" => [
        "breadcrumb" => [
          "ilocations_cms_admin_polygons"
        ]
      ]
    ],
    "polygonEdit" => [
      "permission" => null,
      "activated" => true,
      "path" => "/locations/polygons/:id",
      "name" => "qlocations.admin.polygons.edit",
      "page" => "qlocations/_pages/admin/polygons/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ilocations.cms.sidebar.adminPolygonEdit",
      "icon" => "fas fa-draw-polygon",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "ilocations_cms_admin_polygons"
        ]
      ]
    ],
    "geozones" => [
      "permission" => "ilocations.geozones.manage",
      "activated" => true,
      "path" => "/locations/geozones",
      "name" => "qlocations.admin.geozones.index",
      "crud" => "qlocations/_crud/geozones",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ilocations.cms.sidebar.adminGeozones",
      "icon" => "fas fa-map-marker-alt",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "geozoneCreate" => [
      "permission" => null,
      "activated" => true,
      "path" => "/locations/geozones/create",
      "name" => "qlocations.admin.geozones.create",
      "page" => "qlocations/_pages/admin/geozones/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ilocations.cms.sidebar.adminGeozoneCreate",
      "icon" => "fas fa-map-marker-alt",
      "authenticated" => true,
      "subHeader" => [
        "breadcrumb" => [
          "ilocations_cms_admin_geozones"
        ]
      ]
    ],
    "geozoneEdit" => [
      "permission" => null,
      "activated" => true,
      "path" => "/locations/geozones/:id",
      "name" => "qlocations.admin.geozones.edit",
      "page" => "qlocations/_pages/admin/geozones/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ilocations.cms.sidebar.adminGeozoneEdit",
      "icon" => "fas fa-map-marker-alt",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "ilocations_cms_admin_geozones"
        ]
      ]
    ],
    "neighborhoods" => [
      "permission" => "ilocations.neighborhoods.manage",
      "activated" => true,
      "path" => "/locations/neighborhoods",
      "name" => "qlocations.admin.neighborhoods.index",
      "crud" => "qlocations/_crud/neighborhoods",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ilocations.cms.sidebar.adminNeighborhoods",
      "icon" => "fas fa-home",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "neighborhoodCreate" => [
      "permission" => null,
      "activated" => true,
      "path" => "/locations/neighborhoods/create",
      "name" => "qlocations.admin.neighborhoods.create",
      "page" => "qlocations/_pages/admin/neighborhoods/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ilocations.cms.sidebar.adminNeighborhoodCreate",
      "icon" => "fas fa-home",
      "authenticated" => true,
      "subHeader" => [
        "breadcrumb" => [
          "ilocations_cms_admin_neighborhoods"
        ]
      ]
    ],
    "neighborhoodEdit" => [
      "permission" => null,
      "activated" => true,
      "path" => "/locations/neighborhood/:id",
      "name" => "qlocations.admin.neighborhoods.edit",
      "page" => "qlocations/_pages/admin/neighborhoods/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "ilocations.cms.sidebar.adminNeighborhoodEdit",
      "icon" => "fas fa-home",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "ilocations_cms_admin_neighborhoods"
        ]
      ]
    ]
  ],
  'panel' => [],
  'main' => []
];
