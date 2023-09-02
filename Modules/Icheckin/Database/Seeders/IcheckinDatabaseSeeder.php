<?php

namespace Modules\Icheckin\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IcheckinDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Icheckin\Database\Seeders",
            'seeds' => ['IcheckinModuleTableSeeder'],
        ]);
    }
}
