<?php

namespace Modules\Requestable\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class RequestableDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Requestable\Database\Seeders",
            'seeds' => ['RequestableTableSeeder', 'CreateFormTableSeeder', 'CreateCategoriesRulesTableSeeder'],
        ]);
    }
}
