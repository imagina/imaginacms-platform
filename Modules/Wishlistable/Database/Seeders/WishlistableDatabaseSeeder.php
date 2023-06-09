<?php

namespace Modules\Wishlistable\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class WishlistableDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(WishlistableModuleTableSeeder::class);
        // $this->call("OthersTableSeeder");
    }
}
