<?php

namespace Modules\Iblog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Iblog\Database\Seeders\RoleTableSeeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IblogDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    ProcessSeeds::dispatch([
      "baseClass" => "\Modules\Iblog\Database\Seeders",
      "seeds" => ["IblogModuleTableSeeder", "RoleTableSeeder", "SlugCheckerTableSeeder", "LayoutsBlogTableSeeder",
        "MoveStatusToPostsTranslationsTableSeeder", "MoveStatusToCategoryTranslationsTable"]
    ]);
  }
}
