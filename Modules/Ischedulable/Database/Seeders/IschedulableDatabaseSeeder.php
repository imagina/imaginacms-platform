<?php

namespace Modules\Ischedulable\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ischedulable\Database\Seeders\DaysDatabaseSeeder;

class IschedulableDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->call(DaysDatabaseSeeder::class);
  }
}
