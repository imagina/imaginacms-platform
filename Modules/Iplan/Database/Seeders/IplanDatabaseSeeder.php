<?php

namespace Modules\Iplan\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IplanDatabaseSeeder extends Seeder
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
            'baseClass' => "\Modules\Iplan\Database\Seeders",
            'seeds' => ['IplanModuleTableSeeder'],
        ]);
    }
}
