<?php

namespace Modules\Isite\Services;

class PagesTenantService
{
    /**
     * @param data (Data from "tenant layout")
     */
    public function copyPagesProcess(string $table, array $data)
    {
        //Dentro ya se tomaran en cuenta las otras tablas
        if ($table == 'page__pages') {
            //RowId from database
            $pageIdLayoutBase = $data['id'];

            //Register in new tenant
            $existRegister = \DB::table($table)->select('id')
            ->where('system_name', '=', $data['system_name'])
            ->get();

            //Not exist , so insert data
            if (count($existRegister) == 0) {
                //The record does not exist, but the ID is already occupied in the new tenant
                unset($data['id']);

                //Insert and get Id
                $newPageId = \DB::table($table)->insertGetId($data);

                //Process to Copy Translations
                $this->copyPagesTranslations($pageIdLayoutBase, $newPageId);
            } else {
                $this->checkPageSystemName($data);
            }
        }
    }

    public function copyPagesTranslations($pageIdLayoutBase, $newPageId)
    {
        $table = 'page__page_translations';
        $dataToCopy = \DB::connection('newConnectionTenant')->select('SELECT * FROM '.$table.' WHERE page_id ='.$pageIdLayoutBase);
        foreach ($dataToCopy as $data) {
            $data = (array) $data;
            //The record does not exist, but the ID is already occupied in the new tenant
            unset($data['id']);
            $data['page_id'] = $newPageId;

            \DB::table($table)->insert($data);
        }
    }

    /**
     * @param $data (Data from "tenant layout")
     */
    public function checkPageSystemName(array $data)
    {
        $systemNamePages = ['us', 'contact'];

        if (in_array($data['system_name'], $systemNamePages)) {
            $table = 'page__page_translations';

            //Translations in the Tenant Layout
            $pageTransInTenant = \DB::connection('newConnectionTenant')
            ->select('SELECT * FROM '.$table.' WHERE page_id ='.$data['id']);

            foreach ($pageTransInTenant as $pageTrans) {
                $pageTrans = (array) $pageTrans;

                //Search Translations in the New Tenant by slug and Update
                \DB::table($table)->where('slug', '=', $pageTrans['slug'])->update([
                    'body' => $pageTrans['body'],
                ]);
            }
        }
    }

    /*
    * Metodo de Respaldo -
    * Se utilizo en la primera version
    * Si no encontraba la pagina, se ejecutaba
    */
    public function validationPages(string $table, array $data)
    {
        if ($table == 'page__pages') {
            //Not include all pages
            if ($data['type'] != 'cms') {
                //Update
                \DB::table($table)->where('id', '=', $data['id'])->update([
                    'system_name' => $data['system_name'],
                    'organization_id' => $data['organization_id'],
                ]);
            }
        }
    }
}
