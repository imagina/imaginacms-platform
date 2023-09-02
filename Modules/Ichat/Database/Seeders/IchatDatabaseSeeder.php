<?php

namespace Modules\Ichat\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IchatDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Ichat\Database\Seeders",
            'seeds' => ['IchatModuleTableSeeder'],
        ]);
    }
}
