<?php

namespace Modules\Ifeed\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class IfeedDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(IfeedModuleTableSeeder::class);
        // $this->call("OthersTableSeeder");
    }
}
