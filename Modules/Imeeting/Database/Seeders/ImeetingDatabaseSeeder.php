<?php

namespace Modules\Imeeting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ImeetingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(ImeetingModuleTableSeeder::class);
        $this->call(ZoomProviderSeeder::class);
 
    }

   

}
