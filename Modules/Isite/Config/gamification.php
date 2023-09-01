<?php

$transPrefix = 'isite::gamification';

return [
    //Categories
    'categories' => [
        //Organization wizard
        [
            'systemName' => 'admin_organization_wizard',
            'title' => "$transPrefix.categories.adminOrganizationWizard",
            'description' => "$transPrefix.categories.adminOrganizationWizardDescription",
            'icon' => 'fa-light fa-book-sparkles',
        ],
    ],
    //Activities
    'activities' => [
        //Organization wizard
        [
            'systemName' => 'admin_organization_wizard_register',
            'title' => "$transPrefix.activities.adminOrganizationWizardRegister",
            'description' => "$transPrefix.activities.adminOrganizationWizardRegisterDescription",
            'type' => 1,
            'categoryId' => 'admin_organization_wizard',
            'roles' => [],
        ],
        [
            'systemName' => 'admin_organization_wizard_terms',
            'title' => "$transPrefix.activities.adminOrganizationWizardTerms",
            'description' => "$transPrefix.activities.adminOrganizationWizardTermsDescription",
            'type' => 1,
            'categoryId' => 'admin_organization_wizard',
            'roles' => [],
            'mainImage' => 'modules/isite/img/gamification/terms.png',
        ],
        [
            'systemName' => 'admin_organization_wizard_organization',
            'title' => "$transPrefix.activities.adminOrganizationWizardOrganization",
            'description' => "$transPrefix.activities.adminOrganizationWizardOrganizationDescription",
            'type' => 1,
            'categoryId' => 'admin_organization_wizard',
            'roles' => [],
            'mainImage' => 'modules/isite/img/gamification/organization.png',
        ],
        [
            'systemName' => 'admin_organization_wizard_plan',
            'title' => "$transPrefix.activities.adminOrganizationWizardPlan",
            'description' => "$transPrefix.activities.adminOrganizationWizardPlanDescription",
            'type' => 1,
            'categoryId' => 'admin_organization_wizard',
            'roles' => [],
            'mainImage' => 'modules/isite/img/gamification/plans.png',
        ],
        [
            'systemName' => 'admin_organization_wizard_category',
            'title' => "$transPrefix.activities.adminOrganizationWizardCategory",
            'description' => "$transPrefix.activities.adminOrganizationWizardCategoryDescription",
            'type' => 1,
            'categoryId' => 'admin_organization_wizard',
            'roles' => [],
            'mainImage' => 'modules/isite/img/gamification/category.png',
        ],
        [
            'systemName' => 'admin_organization_wizard_theme',
            'title' => "$transPrefix.activities.adminOrganizationWizardTheme",
            'description' => "$transPrefix.activities.adminOrganizationWizardThemeDescription",
            'type' => 1,
            'categoryId' => 'admin_organization_wizard',
            'roles' => [],
            'mainImage' => 'modules/isite/img/gamification/theme.png',
        ],
    ],
];
