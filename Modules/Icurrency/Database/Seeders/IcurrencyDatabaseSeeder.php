<?php

namespace Modules\Icurrency\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Isite\Jobs\ProcessSeeds;

class IcurrencyDatabaseSeeder extends Seeder
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
      "baseClass" => "\Modules\Icurrency\Database\Seeders",
      "seeds" => ["IcurrencyModuleTableSeeder"]
    ]);
  }
}
