<?php

namespace Modules\Igamification\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IgamificationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Igamification\Database\Seeders",
            'seeds' => ['IgamificationModuleTableSeeder', 'IgamificationSeeder'],
        ]);
    }
}
