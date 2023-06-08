<?php

namespace Modules\Iwhmcs\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class IwhmcsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(IwhmcsModuleTableSeeder::class);
        // $this->call("OthersTableSeeder");
    }
}
