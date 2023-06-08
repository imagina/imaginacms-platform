<?php

namespace Modules\Ihelpers\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Isite\Jobs\ProcessSeeds;

class IhelpersDatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
    ProcessSeeds::dispatch([
      "baseClass" => "\Modules\Ihelpers\Database\Seeders",
      "seeds" => ["IhelpersModuleTableSeeder"]
    ]);
	}
}
