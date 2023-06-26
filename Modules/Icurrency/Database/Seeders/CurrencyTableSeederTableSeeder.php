<?php

namespace Modules\Icurrency\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Icurrency\Entities\Currency;

class CurrencyTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        Currency::create([
            'code' => 'USD',
            'value' => 1,
            'default_currency' => true,
        ]);

        Currency::create([
            'code' => 'COP',
            'value' => 0.000443,
        ]);

        Currency::create([
            'code' => 'MXN',
            'value' => 0.000443,
        ]);

        Currency::create([
            'code' => 'EUR',
            'value' => 0.000443,
        ]);

        Currency::create([
            'code' => 'AUD',
            'value' => 0.000443,
        ]);
    }
}
