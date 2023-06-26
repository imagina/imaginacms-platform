<?php

namespace Modules\Iforms\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IformsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Iforms\Database\Seeders",
            'seeds' => ['IformsModuleTableSeeder', 'BlockTableSeeder', 'ContactFormTableSeeder'],
        ]);
    }
}
