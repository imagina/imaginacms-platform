<?php

namespace Modules\Isite\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class IsiteColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Model::unguard();

      $settings = app('Modules\Setting\Repositories\SettingRepository');

      $settingsToCreate = [
        "isite::brandAddressBar" => '#027be3',
        "isite::brandPrimary" => '#027be3',
        "isite::brandSecondary" => '#26a69a',
        "isite::brandAccent" => '#9c27b0',
        "isite::brandPositive" => '#21ba45',
        "isite::brandNegative" => '#c10015',
        "isite::brandInfo" => '#31ccec',
        "isite::brandWarning" => '#f2c037',
        "isite::brandDark" => '#1d1d1d',
      ];
      
      foreach ($settingsToCreate as $key => $settingToCreate){
        $setting = $settings->findByName($key);
        if(!isset($setting->id)){
          $settings->createOrUpdate([$key => $settingToCreate]);
        }
      }
      
    }
}
