<?php

namespace Modules\Ibooking\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IbookingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Ibooking\Database\Seeders",
            'seeds' => ['IbookingModuleTableSeeder'],
        ]);
    }
}
