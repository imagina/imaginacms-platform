<?php

namespace Modules\Isite\Services;

class MenuTenantService
{

    /** 
    * @param data (Data from "tenant layout")
    */
    public function copyProcess(string $table, array $data)
    {
        
        //Dentro ya se tomaran en cuenta las otras tablas
        if($table=="menu__menuitems"){

            //RowId from database
            $rowIdBase = $data['id'];
           
            //Register in new tenant
            $existRegister = \DB::table($table)->select("id")
            ->where("system_name","=",$data['system_name'])
            ->get();
            
            //Not exist , so insert data
            if(count($existRegister)==0){
                
                //The record does not exist, but the ID is already occupied in the new tenant    
                unset($data['id']);

                if(!is_null($data['parent_id'])){

                    //Get system name from parent in Database Layout
                    $parentInBaseLayout  = \DB::connection("newConnectionTenant")
                    ->select("SELECT system_name FROM ".$table." WHERE id =".$data['parent_id']);

                    //Get id from parent but in the Tenant
                    $parentInTenant = \DB::table($table)->select("id")
                    ->where("system_name","=",$parentInBaseLayout[0]->system_name)
                    ->first();
                    
                    //Delete because this is the id in the parent layout
                    unset($data['parent_id']);

                    //Assign the true id
                    $data['parent_id'] = $parentInTenant->id;
 
                }
                

                //Insert and get Id
                $newId = \DB::table($table)->insertGetId($data);

                //Process to Copy Translations
                $this->copyTranslations($rowIdBase, $newId);

            }

        }

    }

    public function copyTranslations($rowIdBase,$newId)
    {

        $table = "menu__menuitem_translations";
        $attName = "menuitem_id";

        //Search infor in Database Layout
        $dataToCopy = \DB::connection("newConnectionTenant")
        ->select("SELECT * FROM ".$table." WHERE ".$attName." =".$rowIdBase);

        foreach ($dataToCopy as $data) {
            $data = (array)$data;
            //The record does not exist, but the ID is already occupied in the new tenant
            unset($data['id']);
            $data[$attName] = $newId;
           
            \DB::table($table)->insert($data);
        }

    }


   

}