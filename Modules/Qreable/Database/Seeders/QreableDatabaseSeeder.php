<?php

namespace Modules\Qreable\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class QreableDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(QreableModuleTableSeeder::class);
        // $this->call("OthersTableSeeder");
    }
}
