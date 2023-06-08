<?php

namespace Modules\Requestable\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Isite\Jobs\ProcessSeeds;

class RequestableDatabaseSeeder extends Seeder
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
      "baseClass" => "\Modules\Requestable\Database\Seeders",
      "seeds" => ["RequestableTableSeeder","CreateFormTableSeeder","CreateCategoriesRulesTableSeeder"]
    ]);
  }
}
