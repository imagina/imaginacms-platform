<?php

namespace Modules\Icurrency\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IcurrencyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Icurrency\Database\Seeders",
            'seeds' => ['IcurrencyModuleTableSeeder'],
        ]);
    }
}
