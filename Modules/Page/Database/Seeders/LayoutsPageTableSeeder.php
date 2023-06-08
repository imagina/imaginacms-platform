<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Isite\Entities\Layout;


class LayoutsPageTableSeeder extends Seeder
{

  public function run()
  {
    //Seed layouts for contact page
    $contactTemplates = base_path() . "/Modules/Page/Resources/views/frontend/page/layouts/contact";
    $layoutsContact = scandir($contactTemplates);
    $numLayoutsContact = 0;
    foreach ($layoutsContact as $layout) {
      if ($layout != "." && $layout != "..") {
        $numLayoutsContact = $numLayoutsContact + 1;
        Layout::updateOrCreate(
          ['module_name' => 'Page', 'entity_name' => 'Page', 'system_name' => "{$layout}"],
          [
            'module_name' => 'Page',
            'entity_name' => 'Page',
            'path' => "page::frontend.page.layouts.contact.{$layout}.index",
            'record_type' => 'master',
            'status' => '1',
            'system_name' => "{$layout}",
            'es' => [
              'title' => "Plantilla #{$numLayoutsContact} Para Pagina Contacto"
            ],
            'en' => [
              'title' => "Template #{$numLayoutsContact} For Contact Page"
            ]
          ]
        );
      }
    }

    //Seed layouts for about us page
    $ourTemplates = base_path() . "/Modules/Page/Resources/views/frontend/page/layouts/our";
    $layoutsOur = scandir($ourTemplates);
    $numLayoutsOur = 0;
    foreach ($layoutsOur as $layout) {
      if ($layout != "." && $layout != "..") {
        $numLayoutsOur = $numLayoutsOur + 1;
        Layout::updateOrCreate(
          ['module_name' => 'Page', 'entity_name' => 'Page', 'system_name' => "{$layout}"],
          [
            'module_name' => 'Page',
            'entity_name' => 'Page',
            'path' => "page::frontend.page.layouts.our.{$layout}.index",
            'record_type' => 'master',
            'status' => '1',
            'system_name' => "{$layout}",
            'es' => [
              'title' => "Plantilla #{$numLayoutsOur} Para Pagina Nosotros"
            ],
            'en' => [
              'title' => "Template #{$numLayoutsOur} For Page About Us"
            ]
          ]
        );
      }
    }
    //Seed layouts for gallery page
    $galleryTemplates = base_path() . "/Modules/Page/Resources/views/frontend/page/layouts/gallery";
    $layoutsGallery = scandir($galleryTemplates);
    $numLayoutsGallery = 0;
    foreach ($layoutsGallery as $layout) {
      if ($layout != "." && $layout != "..") {
        $numLayoutsGallery = $numLayoutsGallery + 1;
        Layout::updateOrCreate(
          ['module_name' => 'Page', 'entity_name' => 'Page', 'system_name' => "{$layout}"],
          [
            'module_name' => 'Page',
            'entity_name' => 'Page',
            'path' => "page::frontend.page.layouts.gallery.{$layout}.index",
            'record_type' => 'master',
            'status' => '1',
            'system_name' => "{$layout}",
            'es' => [
              'title' => "Plantilla #{$numLayoutsGallery} Para Pagina Galería"
            ],
            'en' => [
              'title' => "Template #{$numLayoutsGallery} For Page Gallery"
            ]
          ]
        );
      }
    }
  }
}
