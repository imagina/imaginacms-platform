<?php

namespace Modules\Ifeed\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class IfeedDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $this->call(IfeedModuleTableSeeder::class);
        // $this->call("OthersTableSeeder");
    }
}
