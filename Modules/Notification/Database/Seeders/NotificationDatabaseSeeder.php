<?php

namespace Modules\Notification\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Isite\Jobs\ProcessSeeds;

class NotificationDatabaseSeeder extends Seeder
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
      "baseClass" => "\Modules\Notification\Database\Seeders",
      "seeds" => ["NotificationTypeTableSeeder", "NotificationTypeTableSeeder", "NotificationProviderTableSeeder"]
    ]);
  }
}
