<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Page\Entities\PageTranslation;
use Modules\Page\Repositories\PageRepository;


class PagesToStartProjectTableSeeder extends Seeder
{

  private $page;

  public function __construct(PageRepository $page)
  {
    $this->page = $page;
  }

  public function run()
  {
    //Seed Home Page/Inicio
    $page = $this->page->findByAttributes(["is_home" => 1]);

    if (!isset($page->id)) {
      $data = [
        'template' => 'default',
        'is_home' => 1,
        'system_name' => 'home',
        'en' => [
          'title' => 'Home page',
          'slug' => 'home',
          'body' => '<p><strong>You made it!</strong></p>
<p>You&#39;ve installed AsgardCMS and are ready to proceed to the <a href="/en/backend">administration area</a>.</p>
<h2>What&#39;s next ?</h2>
<p>Learn how you can develop modules for AsgardCMS by reading our <a href="https://github.com/AsgardCms/Documentation">documentation</a>.</p>
',
          'meta_title' => 'Home page',
        ],
        'es' => [
          'title' => 'Página de Inicio',
          'slug' => 'inicio',
          'body' => '<p><strong>Lo lograste!</strong></p>
<p>has instalado el ImaginaCMS, vé ahora al <a href="/iadmin">área de administración</a>.</p>',
          'meta_title' => 'Página de Inicio',
        ],
      ];
      $this->page->create($data);
    }

    //Seed Our History/Nosotros
    $history = PageTranslation::where("slug", "history")->orWhere("slug", "nosotros")->first();

    if (!isset($history->id)) {
      $data = [
        'template' => 'default',
        'is_home' => 0,
        'system_name' => 'us',
        'en' => [
          'title' => 'Our History',
          'slug' => 'history',
          'body' => '<p>Our history.</p>',
          'meta_title' => 'Our History',
        ],
        'es' => [
          'title' => 'Nosotros',
          'slug' => 'nosotros',
          'body' => '<p>Nosotros.</p>',
          'meta_title' => 'Nosotros',
        ],
      ];
      $this->page->create($data);
    }

    //Seed Our Contact/Contacto
    $contact = PageTranslation::where("slug", "contact")->orWhere("slug", "contacto")->first();
    if (!isset($contact->id)) {
      $data = [
        'template' => 'default',
        'is_home' => 0,
        'system_name' => 'contact',
        'en' => [
          'title' => 'Contact',
          'slug' => 'contact',
          'body' => '<p>Contact.</p>',
          'meta_title' => 'Contact',
        ],
        'es' => [
          'title' => 'Contacto',
          'slug' => 'contacto',
          'body' => '<p>Contacto.</p>',
          'meta_title' => 'Contacto',
        ],
      ];
      $this->page->create($data);
    }
  }
}
