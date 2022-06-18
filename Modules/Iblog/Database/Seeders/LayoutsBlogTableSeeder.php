<?php

namespace Modules\Iblog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Isite\Entities\Layout;


class LayoutsBlogTableSeeder extends Seeder
{

  public function run()
  {
    $posts = base_path() . "/Modules/Iblog/Resources/views/frontend/post/layouts";
    $layoutsPosts = scandir($posts);
    $numPost = 0;
    foreach ($layoutsPosts as $layout) {
      if ($layout != "." && $layout != "..") {
        $numPost = $numPost + 1;
        Layout::updateOrCreate(
          ['module_name' => 'Iblog', 'entity_name' => 'Post', 'system_name' => "{$layout}"],
          [
            'module_name' => 'Iblog',
            'entity_name' => 'Post',
            'path' => "iblog::frontend.post.layouts.{$layout}.index",
            'record_type' => 'master',
            'status' => '1',
            'system_name' => "{$layout}",
            'es' => [
              'title' => "Plantilla #{$numPost} Para Entradas De Blog"
            ],
            'en' => [
              'title' => "Template #{$numPost} For Blog Posts"
            ]
          ]
        );
      }
    }
    $categories = base_path() . "/Modules/Iblog/Resources/views/frontend/category/layouts";
    $layoutsCategories = scandir($categories);
    $numCategories = 0;
    foreach ($layoutsCategories as $layout) {
      if ($layout != "." && $layout != "..") {
        $numCategories = $numCategories + 1;
        Layout::updateOrCreate(
          ['module_name' => 'Iblog', 'entity_name' => 'Category', 'system_name' => "{$layout}"],
          [
            'module_name' => 'Iblog',
            'entity_name' => 'Category',
            'path' => "iblog::frontend.category.layouts.{$layout}.index",
            'record_type' => 'master',
            'status' => '1',
            'system_name' => "{$layout}",
            'es' => [
              'title' => "Plantilla #{$numCategories} Para Categorías De Blog"
            ],
            'en' => [
              'title' => "Template #{$numCategories} For Blog Categories"
            ]
          ]
        );
      }
    }
  }
}
