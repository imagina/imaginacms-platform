<?php

namespace Modules\Ifillable\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ifillable\Database\Seeders\ClearIgnoredFieldsSeeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IfillableDatabaseSeeder extends Seeder
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
      "baseClass" => "\Modules\Ifillable\Database\Seeders",
      "seeds" => ["ClearIgnoredFieldsSeeder", "IfillableModuleTableSeeder"]
    ]);
  }
}
