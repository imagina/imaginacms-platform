<?php

namespace Modules\Isite\Services;

use Modules\Setting\Repositories\SettingRepository;

class SettingService
{

    private $settingRepository;

    public function __construct(
        SettingRepository $settingRepository
    ){
      $this->settingRepository = $settingRepository;
    }
   
    public function updateSettings(array $data,object $organization, object $tenantUser)
    {
        
        \Log::info("========== Update Settings ==========");

        //Site Name - Translatable
        $siteName = $data["title"] ?? "My Site";
        $this->updateSetting("core::site-name",$siteName,true);

        //Iforms - usersToNotify
        $ids = [$tenantUser->id];
        $this->updateSetting("iforms::usersToNotify",$ids);

        //Isite - usersToNotify
        $this->updateSetting("isite::usersToNotify",$ids);

    }


    public function updateSetting($name,$value,$translatable = null)
    {
        
        $setting = $this->settingRepository->findByName($name,false);

        if(!is_null($setting) && !empty($setting)){
            //Update
            if(is_null($translatable)){
                $setting->update(['plainValue' => $value]);
            }else{
                $setting->translate('en')->value = $value;
                $setting->translate('es')->value = $value;
                $setting->save();
            }
           
        }else{
            //Create
            $dataToCreate = [
                "name" => $name,
                "plainValue" => (is_array($value)) ? json_encode($value) : $value,
                "isTranslatable" => $translatable ?? 0
             ];
            $setting = $this->settingRepository->create($dataToCreate);
        }

    }

}