<?php

return [
  'admin' => [
    "posts" => [
      "permission" => "iblog.posts.manage",
      "activated" => true,
      "authenticated" => true,
      "path" => "/blog/posts/index",
      "name" => "qblog.admin.posts",
      "crud" => "qblog/_crud/posts",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iblog.cms.sidebar.adminPosts",
      "icon" => "fas fa-newspaper",
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "categories" => [
      "permission" => "iblog.categories.manage",
      "activated" => true,
      "authenticated" => true,
      "path" => "/blog/categories/index",
      "name" => "qblog.admin.categories",
      "crud" => "qblog/_crud/categories",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iblog.cms.sidebar.adminCategories",
      "icon" => "fas fa-layer-group",
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "postsInternal" => [
      "permission" => "iblog.posts.manage",
      "activated" => true,
      "authenticated" => true,
      "path" => "/blog/posts/internal",
      "name" => "qblog.admin.posts.internal",
      "page" => "qblog/_pages/admin/posts/internal",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iblog.cms.sidebar.adminPostsInternal",
      "icon" => "far fa-newspaper",
      "subHeader" => [
        "refresh" => true
      ]
    ]
  ],
  'panel' => [],
  'main' => []
];
