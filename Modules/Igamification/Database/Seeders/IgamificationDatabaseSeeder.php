<?php

namespace Modules\Igamification\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Isite\Jobs\ProcessSeeds;

class IgamificationDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    ProcessSeeds::dispatch([
      "baseClass" => "\Modules\Igamification\Database\Seeders",
      "seeds" => ["IgamificationModuleTableSeeder", "IgamificationSeeder"]
    ]);
  }
}
