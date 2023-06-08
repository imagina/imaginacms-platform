<?php

namespace Modules\Icommercefreeshipping\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Icommercefreeshiping\Database\Seeders\IcommercefreeshipingModuleTableSeeder;


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
