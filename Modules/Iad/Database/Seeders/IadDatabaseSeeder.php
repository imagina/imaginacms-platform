<?php

namespace Modules\Iad\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IadDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Iad\Database\Seeders",
            'seeds' => ['IadModuleTableSeeder', 'IformComplaintTableSeeder'],
        ]);
    }
}
