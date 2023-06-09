<?php

namespace Modules\Icomments\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class IcommentsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(IcommentsModuleTableSeeder::class);
        // $this->call("OthersTableSeeder");
    }
}