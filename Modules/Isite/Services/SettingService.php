<?php

namespace Modules\Isite\Services;

use Modules\Setting\Repositories\SettingRepository;

class SettingService
{
    private $settingRepository;
    private $log = "Isite:: SettingService|";

    public function __construct(
        SettingRepository $settingRepository
    ) {
        $this->settingRepository = $settingRepository;
    }

    public function updateSettings(array $data, object $organization, object $tenantUser)
    {
        \Log::info('========== Update Settings ==========');

        //Site Name - Translatable
        $siteName = $data['title'] ?? 'My Site';
        $this->updateSetting('core::site-name', $siteName, true);

        //Iforms - usersToNotify
        $ids = [$tenantUser->id];
        $this->updateSetting('iforms::usersToNotify', $ids);

        //Isite - usersToNotify
        $this->updateSetting('isite::usersToNotify', $ids);
    }

    public function updateSetting($name, $value, $translatable = null)
    {
        //\Log::info($this->log.'updateSetting|name:'.$name);

        $setting = $this->settingRepository->findByName($name, false);

        if (! is_null($setting) && ! empty($setting)) {
            //\Log::info($this->log.'updateSetting|Update');
            //Update
            if (is_null($translatable)) {
                $setting->update(['plainValue' => $value]);
            } else {

                if(!is_null($setting->translate('en')))
                $setting->translate('en')->value = $value;
                
                if(!is_null($setting->translate('es')))
                $setting->translate('es')->value = $value;
                $setting->save();
            }
        } else {
            //Create
            //\Log::info($this->log.'updateSetting|Create');
            $dataToCreate = [
                'name' => $name,
                'plainValue' => (is_array($value)) ? json_encode($value) : $value,
                'isTranslatable' => $translatable ?? 0,
            ];
            $setting = $this->settingRepository->create($dataToCreate);
        }
    }
}
