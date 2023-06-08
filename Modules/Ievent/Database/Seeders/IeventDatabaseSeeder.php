<?php

namespace Modules\Ievent\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class IeventDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(IeventModuleTableSeeder::class);
        // $this->call("OthersTableSeeder");
    }
}
