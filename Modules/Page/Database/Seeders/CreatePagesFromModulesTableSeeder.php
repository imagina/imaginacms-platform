<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Page\Repositories\PageRepository;

class CreatePagesFromModulesTableSeeder extends Seeder
{

    private $page;
    
    public function __construct(PageRepository $page)
    {
      $this->page = $page;
    }

   
    public function run()
    {

        Model::unguard();

        \Log::info("----------------------------------------------------------");
        \Log::info("Seeder - CreatePagesFromModules");
        \Log::info("----------------------------------------------------------");
        
        $modules = app('modules')->allEnabled();
    
        foreach ($modules as $module) {
            $lowercaseModule = strtolower($module->get('name'));
            //\Log::info("Module: ".$lowercaseModule);

            $pagesBase = config("asgard.".$lowercaseModule.".config.pagesBase");
            if(!is_null($pagesBase)){
                \Log::info("Creating pages to Module: ".$lowercaseModule);
                foreach ($pagesBase as $key => $page) {
                    $existPage = $this->page->where('system_name',  $page['system_name'])->first();
                    if (!$existPage) {
                        $this->createPage($page);
                    }
                }
            }

        }

    }

    public function createPage(array $data)
    {

        $dataToCreate = [
            'template' => $data['template'] ?? 'default',
            'is_home' => $data['is_home'] ?? 0,
            'system_name' => $data['system_name'],
            'type' => $data['type'] ?? null,
            'en' => [
                'title' => $data['en']['title'] ?? null,
                'slug' => $data['en']['slug'] ?? null,
                'body' => $data['en']['body'] ?? '<p>Page</p>',
                'meta_title' =>  $data['en']['meta_title'] ?? null
            ],
            'es' => [
                'title' => $data['es']['title'] ?? null,
                'slug' => $data['es']['slug'] ?? null,
                'body' => $data['es']['body'] ?? '<p>Pagina</p>',
                'meta_title' =>  $data['es']['meta_title'] ?? null,
            ],
            'options' => $data['options'] ?? null
        ];

        //\Log::info("Data to Create Page: ".\json_encode($dataToCreate));

        $pageCreated = $this->page->create($dataToCreate); 

    }

}
