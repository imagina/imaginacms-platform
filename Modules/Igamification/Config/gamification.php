<?php

$transPrefix = "igamification::igamification.gamification";

return [
  //Categories
  'categories' => [
    //Admin home quick actions
    [
      'systemName' => "admin_home_actions",
      "title" => "$transPrefix.categories.adminHomeActions",
      "description" => "$transPrefix.categories.adminHomeActionsDescription",
      "icon" => "fa-light fa-rocket-launch",
      "mainImage" => "modules/igamification/category/admin_home_actions.png",
      "activityView" => "cardIcon"
    ],
    //Admin home tour
    [
      'systemName' => "admin_home_tour",
      "title" => "$transPrefix.categories.adminHomeTour",
      "description" => "$transPrefix.categories.adminHomeTourDescription",
      "icon" => null
    ],
    //Admin home tour mobile
    [
      'systemName' => "admin_home_tour_mobile",
      "title" => "$transPrefix.categories.adminHomeTourMobile",
      "description" => "$transPrefix.categories.adminHomeTourDescription",
      "icon" => null
    ],
    //Admin CRUD index tour
    [
      'systemName' => "admin_crud_index_tour",
      "title" => "$transPrefix.categories.adminCrudIndexTour",
      "description" => "$transPrefix.categories.adminCrudIndexTourDescription",
      "icon" => null
    ]
  ],
  //Activities
  'activities' => [
    //Admin Home tour
    [
      'systemName' => 'admin_home_tour_menu',
      'title' => "$transPrefix.activities.adminHomeTourMenu",
      'description' => "$transPrefix.activities.adminHomeTourMenuDescription",
      'type' => 6,
      'tourElement' => '#adminMenu',
      'tourElementPosition' => 'right',
      'categoryId' => 'admin_home_tour',
      'icon' => 'fa-light fa-bars',
      'roles' => []
    ],
    [
      'systemName' => 'admin_home_tour_siteActionsGoToSite',
      'title' => "$transPrefix.activities.adminHomeTourGoToSite",
      'description' => "$transPrefix.activities.adminHomeTourGoToSiteDescription",
      'type' => 6,
      'tourElement' => '#siteActionGoToSite',
      'tourElementPosition' => 'bottom',
      'categoryId' => 'admin_home_tour',
      'icon' => 'fa-light fa-up-right-from-square',
      'roles' => []
    ],
    [
      'systemName' => 'admin_home_tour_siteActionsProfileButton',
      'title' => "$transPrefix.activities.adminHomeTourProfile",
      'description' => "$transPrefix.activities.adminHomeTourProfileDescription",
      'type' => 6,
      'tourElement' => '#profileButton',
      'tourElementPosition' => 'bottom',
      'categoryId' => 'admin_home_tour',
      'icon' => 'fa-light fa-user-gear',
      'roles' => []
    ],
    [
      'systemName' => 'admin_home_tour_breadcrumb',
      'title' => "$transPrefix.activities.adminHomeTourBreadcrumb",
      'description' => "$transPrefix.activities.adminHomeTourBreadcrumbDescription",
      'type' => 6,
      'tourElement' => '#routeInformationContent',
      'tourElementPosition' => 'bottom',
      'categoryId' => 'admin_home_tour',
      'icon' => 'fa-light fa-arrow-progress',
      'roles' => []
    ],
    [
      'systemName' => 'admin_home_tour_quickCardsContent',
      'title' => "$transPrefix.activities.adminHomeTourQuickCards",
      'description' => "$transPrefix.activities.adminHomeTourQuickCardsDescription",
      'type' => 6,
      'tourElement' => '#quickCardsContent',
      'tourElementPosition' => 'bottom',
      'categoryId' => 'admin_home_tour',
      'icon' => 'fa-light fa-chart-tree-map',
      'roles' => []
    ],
    [
      'systemName' => 'admin_home_tour_homehelpCenter',
      'title' => "$transPrefix.activities.adminHomeTourHelpCenter",
      'description' => "$transPrefix.activities.adminHomeTourHelpCenterDescription",
      'type' => 6,
      'tourElement' => '#gamificationCategory-help_center',
      'tourElementPosition' => 'bottom',
      'categoryId' => 'admin_home_tour',
      'icon' => 'fa-light fa-comment-question',
      'roles' => []
    ],
    [
      'systemName' => 'admin_home_tour_homeActions',
      'title' => "$transPrefix.activities.adminHomeTourHomeActions",
      'description' => "$transPrefix.activities.adminHomeTourHomeActionsDescription",
      'type' => 6,
      'tourElement' => '#gamificationCategory-admin_home_actions',
      'tourElementPosition' => 'bottom',
      'categoryId' => 'admin_home_tour',
      'icon' => 'fa-light fa-rocket-launch',
      'roles' => []
    ],
    //Admin Home tour (Mobile)
    [
      'systemName' => 'admin_home_tour_menu_mobile',
      'title' => "$transPrefix.activities.adminHomeTourMenu",
      'description' => "$transPrefix.activities.adminHomeTourMenuDescription",
      'type' => 6,
      'tourElement' => '#footerMobileMenu',
      'tourElementPosition' => 'top',
      'categoryId' => 'admin_home_tour_mobile',
      'icon' => 'fa-light fa-bars',
      'roles' => []
    ],
    [
      'systemName' => 'admin_home_tour_siteActionsProfileButton_mobile',
      'title' => "$transPrefix.activities.adminHomeTourProfile",
      'description' => "$transPrefix.activities.adminHomeTourProfileDescription",
      'type' => 6,
      'tourElement' => '#footerMobileProfile',
      'tourElementPosition' => 'top',
      'categoryId' => 'admin_home_tour_mobile',
      'icon' => 'fa-light fa-user-gear',
      'roles' => []
    ],
    [
      'systemName' => 'admin_home_tour_mainAction_mobile',
      'title' => "$transPrefix.activities.adminHomeTourMainActionMobile",
      'description' => "$transPrefix.activities.adminHomeTourMainActionMobileDescription",
      'type' => 6,
      'tourElement' => '#footerMobileMain',
      'tourElementPosition' => 'top',
      'categoryId' => 'admin_home_tour_mobile',
      'icon' => 'fa-light fa-bolt',
      'roles' => []
    ],
    [
      'systemName' => 'admin_home_tour_siteActionsGoToSite_mobile',
      'title' => "$transPrefix.activities.adminHomeTourGoToSite",
      'description' => "$transPrefix.activities.adminHomeTourGoToSiteDescription",
      'type' => 6,
      'tourElement' => '#footerMobileGoToSite',
      'tourElementPosition' => 'bottom',
      'categoryId' => 'admin_home_tour_mobile',
      'icon' => 'fa-light fa-up-right-from-square',
      'roles' => []
    ],
    [
      'systemName' => 'admin_home_tour_quickCardsContent_mobile',
      'title' => "$transPrefix.activities.adminHomeTourQuickCards",
      'description' => "$transPrefix.activities.adminHomeTourQuickCardsDescription",
      'type' => 6,
      'tourElement' => '#quickCardsContent',
      'tourElementPosition' => 'bottom',
      'categoryId' => 'admin_home_tour_mobile',
      'icon' => 'fa-light fa-chart-tree-map',
      'roles' => []
    ],
    [
      'systemName' => 'admin_home_tour_homeActions_mobile',
      'title' => "$transPrefix.activities.adminHomeTourHomeActions",
      'description' => "$transPrefix.activities.adminHomeTourHomeActionsDescription",
      'type' => 6,
      'tourElement' => '#gamificationCategory-admin_home_actions',
      'tourElementPosition' => 'bottom',
      'categoryId' => 'admin_home_tour_mobile',
      'icon' => 'fa-light fa-rocket-launch',
      'roles' => []
    ],
    //Admin CRUD index tour
    [
      'systemName' => 'admin_crud_index_tour_list',
      'title' => "$transPrefix.activities.adminCrudIndexTourList",
      'description' => "$transPrefix.activities.adminCrudIndexTourListDescription",
      'type' => 6,
      'tourElement' => '.q-table__middle',
      'tourElementPosition' => 'top',
      'categoryId' => 'admin_crud_index_tour',
      'icon' => 'fa-light fa-list',
      'roles' => []
    ],
    [
      'systemName' => 'admin_crud_index_tour_pagination',
      'title' => "$transPrefix.activities.adminCrudIndexTourPagination",
      'description' => "$transPrefix.activities.adminCrudIndexTourPaginationDescription",
      'type' => 6,
      'tourElement' => '.bottonCrud',
      'tourElementPosition' => 'top',
      'categoryId' => 'admin_crud_index_tour',
      'icon' => 'fa-light fa-input-numeric',
      'roles' => []
    ],
    [
      'systemName' => 'admin_crud_index_tour_pageActions',
      'title' => "$transPrefix.activities.adminCrudIndexPageActions",
      'description' => "$transPrefix.activities.adminCrudIndexPageActionsDescription",
      'type' => 6,
      'tourElement' => '#pageActionscomponent',
      'tourElementPosition' => 'bottom',
      'categoryId' => 'admin_crud_index_tour',
      'icon' => 'fa-light fa-square-dashed-circle-plus',
      'roles' => []
    ],
    [
      'systemName' => 'admin_crud_index_tour_actionsColumn',
      'title' => "$transPrefix.activities.adminCrudIndexTourActionsColumn",
      'description' => "$transPrefix.activities.adminCrudIndexTourActionsColumnDescription",
      'type' => 6,
      'tourElement' => '.crudIndexActionsColumn',
      'tourElementPosition' => 'bottom',
      'categoryId' => 'admin_crud_index_tour',
      'icon' => 'fa-light fa-pen-to-square',
      'roles' => []
    ]
  ]
];
