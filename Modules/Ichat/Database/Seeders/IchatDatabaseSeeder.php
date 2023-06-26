<?php

namespace Modules\Ichat\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IchatDatabaseSeeder extends Seeder
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
            'baseClass' => "\Modules\Ichat\Database\Seeders",
            'seeds' => ['IchatModuleTableSeeder'],
        ]);
    }
}
