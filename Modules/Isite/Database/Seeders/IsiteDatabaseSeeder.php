<?php

namespace Modules\Isite\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Isite\Jobs\ProcessSeeds;

class IsiteDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Isite\Database\Seeders",
            'seeds' => ['IsiteModuleTableSeeder'],
        ]);

        $settings = app('Modules\Setting\Repositories\SettingRepository');

        $settingsToCreate = [
            'isite::logo1' => json_encode(['medias_single' => ['isite::logo1' => null]]),
            'isite::logo2' => json_encode(['medias_single' => ['isite::logo2' => null]]),
            'isite::logo3' => json_encode(['medias_single' => ['isite::logo3' => null]]),
        ];

        foreach ($settingsToCreate as $key => $settingToCreate) {
            $setting = $settings->findByName($key);
            if (! isset($setting->id)) {
                $settings->createOrUpdate([$key => $settingToCreate]);
            }
        }

        ProcessSeeds::dispatch([
            'baseClass' => "\Modules\Isite\Database\Seeders",
            'seeds' => ['IsiteColorsSeeder', 'IsiteCustomSourcesSeeder', 'IformOrganizationDefaultRegisterTableSeeder'],
        ]);
    }
}
