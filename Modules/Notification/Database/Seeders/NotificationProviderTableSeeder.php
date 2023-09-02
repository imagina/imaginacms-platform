<?php

namespace Modules\Notification\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Notification\Entities\Provider;

class NotificationProviderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $emailProvider = DB::table('notification__providers')->where('system_name', 'email')->first();

        if (! isset($emailProvider->id)) {
            Provider::create([
                'name' => 'Email',
                'system_name' => 'email',
                'status' => 1,
                'default' => 1,
                'type' => 'email',
                'options' => ['fromName' => null, 'fromEmail' => null, 'saveInDatabase' => 1],
            ]);
        }

        $providers = config('asgard.notification.config.providers');

        foreach ($providers as $provider) {
            $databaseProvider = DB::table('notification__providers')->where('system_name', $provider['systemName'])->first();
            if (! isset($databaseProvider->id)) {
                Provider::create([
                    'name' => $provider['name'],
                    'system_name' => $provider['systemName'],
                    'status' => 0,
                    'default' => 0,
                    'type' => $provider['type'],
                    'fields' => $provider['fields'],
                ]);
            }
        }
    }
}
