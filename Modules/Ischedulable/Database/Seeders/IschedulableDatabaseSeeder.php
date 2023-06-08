<?php

namespace Modules\Ischedulable\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ischedulable\Database\Seeders\DaysDatabaseSeeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IschedulableDatabaseSeeder extends Seeder
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
      "baseClass" => "\Modules\Ischedulable\Database\Seeders",
      "seeds" => ["IschedulableModuleTableSeeder", "DaysDatabaseSeeder"]
    ]);
  }
}
