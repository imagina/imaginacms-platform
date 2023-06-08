<?php

namespace Modules\Media\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class MediaDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    Model::unguard();
    ProcessSeeds::dispatch([
      "baseClass" => "\Modules\Media\Database\Seeders",
      "seeds" => ["MediaModuleTableSeeder", "DeleteSvgOfImageTypes"]
    ]);
  }
}
