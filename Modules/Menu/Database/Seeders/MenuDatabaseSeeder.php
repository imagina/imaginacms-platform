<?php

namespace Modules\Menu\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class MenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        //Seed cms pages
        $this->call(MenuModuleTableSeeder::class);
        //$this->call(CMSSidebarDatabaseSeeder::class);
    }
}
