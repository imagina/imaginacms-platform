<?php

return [
    'admin' => [
        'plans' => [
            'permission' => 'iplan.plans.manage',
            'activated' => true,
            'path' => '/plans',
            'name' => 'qplan.admin.plans.index',
            'crud' => 'qplan/_crud/plans',
            'page' => 'qcrud/_pages/admin/crudPage',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'iplan.cms.sidebar.adminPlans',
            'icon' => 'fas fa-window-restore',
            'authenticated' => true,
            'subHeader' => [
                'refresh' => true,
            ],
        ],
        'limits' => [
            'permission' => 'iplan.limits.manage',
            'activated' => true,
            'path' => '/limits',
            'name' => 'qplan.admin.limits.index',
            'crud' => 'qplan/_crud/limits',
            'page' => 'qcrud/_pages/admin/crudPage',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'iplan.cms.sidebar.adminLimits',
            'icon' => 'fas fa-key',
            'authenticated' => true,
            'subHeader' => [
                'refresh' => true,
                'breadcrumb' => [
                    'iplan_cms_admin_plans',
                ],
            ],
        ],
        'categories' => [
            'permission' => 'iplan.categories.manage',
            'activated' => true,
            'path' => '/categories',
            'name' => 'qplan.admin.categories.index',
            'crud' => 'qplan/_crud/planCategories',
            'page' => 'qcrud/_pages/admin/crudPage',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'iplan.cms.sidebar.adminCategories',
            'icon' => 'fas fa-layer-group',
            'authenticated' => true,
            'subHeader' => [
                'refresh' => true,
                'breadcrumb' => [
                    'iplan_cms_admin_plans',
                ],
            ],
        ],
        'entityPlans' => [
            'permission' => 'iplan.entityplans.manage',
            'activated' => true,
            'path' => '/entityPlans',
            'name' => 'qplan.admin.entityPlans.index',
            'crud' => 'qplan/_crud/entityPlans',
            'page' => 'qcrud/_pages/admin/crudPage',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'iplan.cms.sidebar.adminEntityPlans',
            'icon' => 'fas fa-tasks',
            'authenticated' => true,
            'subHeader' => [
                'refresh' => true,
                'breadcrumb' => [
                    'iplan_cms_admin_plans',
                ],
            ],
        ],
        'subscriptions' => [
            'permission' => 'iplan.subscriptions.manage',
            'activated' => true,
            'path' => '/subscriptions',
            'name' => 'qplan.admin.subscriptions.index',
            'crud' => 'qplan/_crud/subscriptions',
            'page' => 'qcrud/_pages/admin/crudPage',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'iplan.cms.sidebar.adminSubscriptions',
            'icon' => 'fas fa-file-contract',
            'authenticated' => true,
            'subHeader' => [
                'refresh' => true,
                'breadcrumb' => [
                    'iplan_cms_admin_plans',
                ],
            ],
        ],
        'subscriptionsEdit' => [
            'permission' => 'iplan.subscriptions.edit',
            'activated' => true,
            'path' => '/subscriptions/:id',
            'name' => 'qplan.admin.subscriptions.edit',
            'page' => 'qplan/_pages/admin/subscriptions/form',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'iplan.cms.sidebar.editSubscriptions',
            'icon' => 'fas fa-file-signature',
            'authenticated' => true,
            'subHeader' => [
                'refresh' => true,
                'breadcrumb' => [
                    'iplan_cms_admin_plans',
                    'iplan_cms_main_subscriptions',
                ],
            ],
        ],
    ],
    'panel' => [],
    'main' => [
        'userSubscriptions' => [
            'permission' => 'iplan.plans.ownPlans',
            'activated' => true,
            'path' => '/plans/me',
            'name' => 'qplan.admin.my.plans',
            'page' => 'qplan/_pages/main/myPlan',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'iplan.cms.sidebar.adminUserSubscriptions',
            'icon' => 'fas fa-window-restore',
            'authenticated' => true,
            'subHeader' => [
                'refresh' => true,
            ],
        ],
    ],
];
