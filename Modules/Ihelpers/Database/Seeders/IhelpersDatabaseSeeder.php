<?php

namespace Modules\Ihelpers\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IhelpersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Ihelpers\Database\Seeders",
            'seeds' => ['IhelpersModuleTableSeeder'],
        ]);
    }
}
