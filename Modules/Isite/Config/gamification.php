<?php

$transPrefix = "isite::gamification";

return [
  //Categories
  'categories' => [
    //Organization wizard
    [
      'systemName' => "admin_organization_wizard",
      "title" => "$transPrefix.categories.adminOrganizationWizard",
      "description" => "$transPrefix.categories.adminOrganizationWizardDescription",
      "icon" => "fa-light fa-book-sparkles",
    ]
  ],
  //Activities
  'activities' => [
    //Admin Home
    [
      'systemName' => 'admin_home_actions_settings',
      'title' => "$transPrefix.activities.settings",
      'description' => "$transPrefix.activities.settingsDescription",
      'type' => 1,
      'url' => "iadmin/#/site/settings",
      'permission' => 'isite.settings.manage',
      'categoryId' => 'admin_home_actions',
      'icon' => 'fal fa-cog',
      'roles' => []
    ],
    [
      'systemName' => 'admin_home_actions_settingsOrganization',
      'title' => "$transPrefix.activities.settingsOrganization",
      'description' => "$transPrefix.activities.settingsOrganizationDescription",
      'type' => 1,
      'url' => "iadmin/#/site/my-organizations",
      'permission' => 'isite.organizations.index',
      'categoryId' => 'admin_home_actions',
      'icon' => 'fal fa-crown',
      'roles' => []
    ],
    //Organization wizard
    [
      'systemName' => 'admin_organization_wizard_welcome',
      'title' => "$transPrefix.activities.adminOrganizationWizardWelcome",
      'description' => "$transPrefix.activities.adminOrganizationWizardWelcomeDescription",
      'type' => 1,
      'categoryId' => 'admin_organization_wizard',
      'roles' => [],
      "mainImage" => "modules/isite/img/gamification/welcome.png"
    ],
    [
      'systemName' => 'admin_organization_wizard_register',
      'title' => "$transPrefix.activities.adminOrganizationWizardRegister",
      'description' => "$transPrefix.activities.adminOrganizationWizardRegisterDescription",
      'type' => 1,
      'categoryId' => 'admin_organization_wizard',
      'roles' => []
    ],
    [
      'systemName' => 'admin_organization_wizard_terms',
      'title' => "$transPrefix.activities.adminOrganizationWizardTerms",
      'description' => "$transPrefix.activities.adminOrganizationWizardTermsDescription",
      'type' => 1,
      'categoryId' => 'admin_organization_wizard',
      'roles' => [],
      "mainImage" => "modules/isite/img/gamification/terms.png"
    ],
    [
      'systemName' => 'admin_organization_wizard_organization',
      'title' => "$transPrefix.activities.adminOrganizationWizardOrganization",
      'description' => "$transPrefix.activities.adminOrganizationWizardOrganizationDescription",
      'type' => 1,
      'categoryId' => 'admin_organization_wizard',
      'roles' => [],
      "mainImage" => "modules/isite/img/gamification/organization.png"
    ],
    [
      'systemName' => 'admin_organization_wizard_plan',
      'title' => "$transPrefix.activities.adminOrganizationWizardPlan",
      'description' => "$transPrefix.activities.adminOrganizationWizardPlanDescription",
      'type' => 1,
      'categoryId' => 'admin_organization_wizard',
      'roles' => [],
      "mainImage" => "modules/isite/img/gamification/plans.png"
    ],
    [
      'systemName' => 'admin_organization_wizard_category',
      'title' => "$transPrefix.activities.adminOrganizationWizardCategory",
      'description' => "$transPrefix.activities.adminOrganizationWizardCategoryDescription",
      'type' => 1,
      'categoryId' => 'admin_organization_wizard',
      'roles' => [],
      "mainImage" => "modules/isite/img/gamification/category.png"
    ],
    [
      'systemName' => 'admin_organization_wizard_theme',
      'title' => "$transPrefix.activities.adminOrganizationWizardTheme",
      'description' => "$transPrefix.activities.adminOrganizationWizardThemeDescription",
      'type' => 1,
      'categoryId' => 'admin_organization_wizard',
      'roles' => [],
      "mainImage" => "modules/isite/img/gamification/theme.png"
    ],
    [
      'systemName' => 'admin_organization_wizard_summary',
      'title' => "$transPrefix.activities.adminOrganizationWizardSummary",
      'description' => "$transPrefix.activities.adminOrganizationWizardSummaryDescription",
      'type' => 1,
      'categoryId' => 'admin_organization_wizard',
      'roles' => []
    ],
    [
      'systemName' => 'admin_organization_wizard_ai',
      'title' => "$transPrefix.activities.adminOrganizationWizardAI",
      'description' => "$transPrefix.activities.adminOrganizationWizardAIDescription",
      'type' => 1,
      'categoryId' => 'admin_organization_wizard',
      'roles' => [],
      "mainImage" => "modules/isite/img/gamification/ai.png"
    ],
  ]
];
