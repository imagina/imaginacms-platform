<?php

namespace Modules\Icommercefreeshipping\Database\Seeders;

use Illuminate\Database\Seeder;

class IcommercefreeshippingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(IcommercefreeshippingModuleTableSeeder::class);
        $this->call(PaymentTableSeeder::class);
        //$this->call(GeozoneTableSeeder::class);
    }
}
