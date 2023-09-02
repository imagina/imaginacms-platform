<?php

namespace Modules\Ibinnacle\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IbinnacleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Ibinnacle\Database\Seeders",
            'seeds' => ['IbinnacleModuleTableSeeder'],
        ]);
    }
}
