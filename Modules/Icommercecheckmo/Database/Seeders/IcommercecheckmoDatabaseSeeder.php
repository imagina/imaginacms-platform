<?php

namespace Modules\Icommercecheckmo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Isite\Jobs\ProcessSeeds;

class IcommercecheckmoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        ProcessSeeds::dispatch([
            "baseClass" => "\Modules\Icommercecheckmo\Database\Seeders",
            "seeds" => ["IcommercecheckmoModuleTableSeeder", "IcommercecheckmoSeeder"]
        ]);
 
    }

}
