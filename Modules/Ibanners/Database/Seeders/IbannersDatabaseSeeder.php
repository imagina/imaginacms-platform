<?php

namespace Modules\Ibanners\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IbannersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Ibanners\Database\Seeders",
            'seeds' => ['IbannersModuleTableSeeder'],
        ]);
    }
}
