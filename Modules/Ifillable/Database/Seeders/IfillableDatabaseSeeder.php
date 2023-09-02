<?php

namespace Modules\Ifillable\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IfillableDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Ifillable\Database\Seeders",
            'seeds' => ['ClearIgnoredFieldsSeeder', 'IfillableModuleTableSeeder'],
        ]);
    }
}
