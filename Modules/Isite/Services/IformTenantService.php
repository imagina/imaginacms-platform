<?php

namespace Modules\Isite\Services;

class IformTenantService
{

    public function copyFormsProcess(string $table, array $data)
    {
        
        //Dentro ya se tomaran en cuenta las otras tablas
        if($table=="iforms__forms"){

        $formIdLayoutBase = $data['id'];
        //\Log::info("Checking to copy Form ID: ".$formIdLayoutBase);

        //Se busca por system name
        $existRegister = \DB::table($table)->select("id")->where("system_name","=",$data['system_name'])->get();
        
        //Not exist , so insert data
        if(count($existRegister)==0){
            
            //Process to Form
            //\Log::info("Copying data from: Form");

            // El registro no existe, pero el ID de ese form ya sta ocupado en el new tenant    
            unset($data['id']);
            //Insert and get Id
            $newFormId = \DB::table($table)->insertGetId($data);

            //Process to Copy Form Translations
            $this->copyFormTranslations($formIdLayoutBase, $newFormId);

            //Process to Copy Blocks
            $newBlockId = $this->copyFormBlocks($formIdLayoutBase, $newFormId);
            
            //Process to Copy Fields and Fields Translations
            $this->copyFormFields($formIdLayoutBase, $newFormId,$newBlockId);
            
        }

        }


    }

    public function copyFormTranslations($formIdLayoutBase,$newFormId)
    {

        //\Log::info("Copying data from: Translations");

        $table = "iforms__form_translations";
        $dataToCopy = \DB::connection("newConnectionTenant")->select("SELECT * FROM ".$table." WHERE form_id =".$formIdLayoutBase);
        foreach ($dataToCopy as $data) {
        $data = (array)$data;
        // El registro no existe, pero el ID ya sta ocupado en el new tenant
        unset($data['id']);
        $data["form_id"] = $newFormId;
        //Insert
        \DB::table($table)->insert($data);
        }

    }

    public function copyFormBlocks($formIdLayoutBase,$newFormId)
    {
        
        //\Log::info("Copying data from: Blocks");

        $table = "iforms__blocks";
        $dataToCopy = \DB::connection("newConnectionTenant")->select("SELECT * FROM ".$table." WHERE form_id =".$formIdLayoutBase);
        foreach ($dataToCopy as $data) {
        $data = (array)$data;
        // El registro no existe, pero el ID ya sta ocupado en el new tenant
        unset($data['id']);
        $data["form_id"] = $newFormId;
        //Insert and get Id
        $newBlockId = \DB::table($table)->insertGetId($data);
        }

        return $newBlockId;

    }

    public function copyFormFields($formIdLayoutBase,$newFormId,$newBlockId)
    {
        
        //\Log::info("Copying data from: Fields");

        $table = "iforms__fields";
        $dataToCopy = \DB::connection("newConnectionTenant")->select("SELECT * FROM ".$table." WHERE form_id =".$formIdLayoutBase);
        foreach ($dataToCopy as $data) {
        $data = (array)$data;

        $oldFieldId = $data['id'];

        // El registro no existe, pero el ID ya sta ocupado en el new tenant
        unset($data['id']);
        $data["form_id"] = $newFormId;
        $data["block_id"] = $newBlockId;

        //Insert and get Id
        $newFieldId = \DB::table($table)->insertGetId($data);

        $this->copyFormFieldsTranslations($oldFieldId,$newFieldId);

        }
    }

    public function copyFormFieldsTranslations($oldFieldId,$newFieldId)
    {
        
        //\Log::info("Copying data from: Fields Translation");

        $table = "iforms__field_translations";
        $dataToCopy = \DB::connection("newConnectionTenant")->select("SELECT * FROM ".$table." WHERE field_id =".$oldFieldId);
        foreach ($dataToCopy as $data) {
        $data = (array)$data;
        // El registro no existe, pero el ID ya sta ocupado en el new tenant
        unset($data['id']);
        $data["field_id"] = $newFieldId;
        //Insert
        \DB::table($table)->insert($data);
        }

    }

}