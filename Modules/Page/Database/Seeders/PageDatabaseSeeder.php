<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Page\Entities\PageTranslation;
use Modules\Page\Repositories\PageRepository;
use Modules\Isite\Jobs\ProcessSeeds;

class PageDatabaseSeeder extends Seeder
{
  /**
   * @var PageRepository
   */
  private $page;

  public function __construct(PageRepository $page)
  {
    $this->page = $page;
  }

  public function run()
  {
    Model::unguard();
    $this->call(PageModuleTableSeeder::class);
    $this->call(PagesToStartProjectTableSeeder::class);
    $this->call(CreatePagesFromModulesTableSeeder::class);
    $this->call(LayoutsPageTableSeeder::class);
    //Seed cms pages
    //$this->call(CMSPagesDatabaseSeeder::class);
  }
}
