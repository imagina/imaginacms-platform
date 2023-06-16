<?php

namespace Modules\Iprofile\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Iprofile\Entities\Setting;

class AssignedSettingsInRoles extends Seeder
{
    public function run()
    {
        Model::unguard();

        $module = app('modules');
        $rolesRepository = app("Modules\Iprofile\Repositories\RoleApiRepository");
        $settingsRepository = app("Modules\Setting\Repositories\SettingRepository");
        $roles = $rolesRepository->getItemsBy();
        $data = [];
        $translatableSettings = [];
        $plainSettings = [];

        $modulesWithSettings = $settingsRepository->moduleSettings($module->allEnabled());

        foreach ($modulesWithSettings as $key => $module) {
            $translatableSettings[$key] = $settingsRepository->translatableModuleSettings($key);
            $plainSettings[$key] = $settingsRepository->plainModuleSettings($key);
        }

        $mergedSettings = array_merge_recursive($translatableSettings, $plainSettings);

        $modules = json_decode(json_encode($mergedSettings));

        foreach ($modules as $key => $module) {
            $moduleName = strtolower($key);
            foreach ($module as $key => $setting) {
                if (isset($setting) && isset($setting->onlySuperAdmin) && $setting->onlySuperAdmin == false) {
                    $settingAssigned = $moduleName.'::'.$key;
                    array_push($data, $settingAssigned);
                }
            }
        }
        foreach ($roles as $role) {
            if (isset($role->slug) && $role->slug != 'super-admin') {
                // Update or create the setting
                Setting::updateOrCreate(
                    ['related_id' => $role->id, 'entity_name' => 'role', 'name' => 'assignedSettings'],
                    [
                        'related_id' => $role->id,
                        'entity_name' => 'role',
                        'name' => 'assignedSettings',
                        'value' => $data,
                    ]
                );
            }
        }
    }
}
