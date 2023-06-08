<?php

namespace Modules\Ibuilder\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Isite\Jobs\ProcessSeeds;

class IbuilderDatabaseSeeder extends Seeder
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
      "baseClass" => "\Modules\Ibuilder\Database\Seeders",
      "seeds" => ["IbuilderModuleTableSeeder", "FixBlocksMovedSeeder"]
    ]);
  }
}
