<?php

namespace Modules\Iforms\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IformsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Iforms\Database\Seeders",
            'seeds' => ['IformsModuleTableSeeder', 'BlockTableSeeder', 'ContactFormTableSeeder'],
        ]);
    }
}
