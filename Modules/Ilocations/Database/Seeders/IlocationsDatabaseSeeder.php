<?php

namespace Modules\Ilocations\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Ilocations\Jobs\ProcessLocations;

class IlocationsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProcessLocations::dispatch();
    }
}
