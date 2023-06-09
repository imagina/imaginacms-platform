<?php

namespace Modules\Ilocations\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Ilocations\Jobs\ProcessLocations;

class IlocationsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProcessLocations::dispatch();
    }
}
