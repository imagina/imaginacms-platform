<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IcommerceDatabaseSeeder extends Seeder
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
            'baseClass' => "\Modules\Icommerce\Database\Seeders",
            'seeds' => ['IcommerceModuleTableSeeder', 'OrderStatusTableSeeder', 'ItemTypeTableSeeder', 'CurrencyTableSeeder',
                'StoreTableSeeder', 'NotificationRulesTableSeeder', 'IformRequestQuoteTableSeeder', 'CreateFormsTableSeeder',
                'IcommerceFixOrdersStatusPendingDuplicatedTableSeeder'],
        ]);
    }
}