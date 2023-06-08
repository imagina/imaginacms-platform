<?php

namespace Modules\Page\Services;

use Modules\Page\Repositories\PageRepository;

class PageService
{
    
    public $pageRepository;


    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /*
    *
    */
    public function getDataLayout($systemName,$path){
        
        $tpl = null;
        $layoutSystemName = null;

        if(!is_null(tenant())){
           
            $params = [
              "filter" => [
                "field" => "system_name",
                'organizationId' => tenant()->id
              ],
              "include" => [],
              "fields" => [],
            ];
        
            $page = $this->pageRepository->getItem($systemName, json_decode(json_encode($params)));

            if(!empty($page)){
                $layoutPath = $page->typeable->layout_path ?? null;

                //Para que tome el index dentro del layout en el Theme
                if (view()->exists($layoutPath.$path)) {
                  $tpl = $layoutPath.$path;
                  $layoutSystemName = $page->typeable->layout->system_name;
                }
                
            } 

        }

        
        //result
        $infor = [
            'tpl' => $tpl,
            'layoutSystemName' => $layoutSystemName
        ];

        return $infor;
    }

    
}
