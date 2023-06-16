<?php

return [
    'admin' => [
        'index' => [
            'permission' => 'slider.sliders.manage',
            'activated' => true,
            'path' => '/slider/index',
            'name' => 'qslider.admin.sliders',
            'crud' => 'qslider/_crud/sliders',
            'page' => 'qcrud/_pages/admin/crudPage',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'slider.cms.sidebar.adminSlider',
            'icon' => 'fas fa-file-export',
            'authenticated' => true,
            'subHeader' => [
                'refresh' => true,
            ],
        ],
        'showSlider' => [
            'permission' => 'slider.sliders.index',
            'activated' => true,
            'path' => '/slider/show/:id',
            'name' => 'qslider.admin.sliders.show',
            'page' => 'qslider/_pages/admin/sliders/form',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'slider.cms.sidebar.adminSliderEdit',
            'icon' => 'fas fa-image',
            'authenticated' => true,
            'subHeader' => [
                'refresh' => true,
                'breadcrumb' => [
                    'slider_cms_admin_index',
                ],
            ],
        ],
        'createSlide' => [
            'permission' => 'slider.sliders.index',
            'activated' => true,
            'path' => '/slide/create/:sliderId',
            'name' => 'qslider.admin.slide.create',
            'page' => 'qslider/_pages/admin/slide/create.vue',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'slider.cms.sidebar.adminIndex',
            'icon' => 'fas fa-images',
            'authenticated' => true,
        ],
        'updateSlide' => [
            'permission' => 'slider.sliders.index',
            'activated' => true,
            'path' => '/slide/update/:sliderId/:id',
            'name' => 'qslider.admin.slide.update',
            'page' => 'qslider/_pages/admin/slide/show.vue',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'slider.cms.sidebar.adminIndex',
            'icon' => 'fas fa-images',
            'authenticated' => true,
        ],
    ],
    'panel' => [],
    'main' => [],
];
