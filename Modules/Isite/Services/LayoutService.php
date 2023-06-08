<?php

namespace Modules\Isite\Services;

use Modules\Isite\Repositories\LayoutRepository;
use Illuminate\Support\Str;

use Illuminate\Filesystem\Filesystem;

class LayoutService
{

    private $layout;
    private $finder;
    
    public function __construct(
        LayoutRepository $layout,
        Filesystem $finder
    ){
      $this->layout = $layout;
      $this->finder = $finder;
    }

    public function create(array $data,object $organization)
    {
        
        \Log::info("----------------------------------------------------------");
        \Log::info("Creating new layout...");
        \Log::info("----------------------------------------------------------");

        $systemName = Str::slug($data['title'], '-');

        //Proccess to create new layout
        $layoutCreated = $this->createLayoutInCentralDB($data,$systemName);
        $this->createFolderInTheme($systemName);
        $this->updateConfigFile($data,$systemName,$organization);

        //Update organization with new layout
        $organization->layout_id = $layoutCreated->id;
        $organization->save();

        return $layoutCreated;

    }

    public function createLayoutInCentralDB(array $data, string $systemName)
    {
        \Log::info("Creating layout in Central Database...");

        $dataToCreate = [
            'system_name' => $systemName,
            'module_name' => 'Page',
            'entity_name' => 'Page',
            'entity_type' => 'Modules\Page\Entities\Page',
            'path' => 'pages.content.layouts.'.$systemName,
            'status' => $data['status'] ?? 1,
            'en' => [
                'title' => $data['title'] ?? null,
            ],
            'es' => [
                'title' => $data['title'] ?? null,
            ],
        ];

        $layoutCreated = $this->layout->create($dataToCreate); 

        return $layoutCreated;
    }

    public function createFolderInTheme(string $systemName)
    {
        \Log::info("Creating folder in Theme");

        $source = base_path('Modules/Isite/Resources/views/frontend/tenant/theme/base');
        $to = base_path('Themes/ImaginaTheme/views/pages/content/layouts/'.$systemName);  
        
        \Log::info("Copy - source: ".$source);
        \Log::info("Copy - to: ".$to);
    
        \File::copyDirectory($source, $to);

    }

    public function updateConfigFile(array $data, string $systemName, object $organization)
    {
        \Log::info("Updating config file: tenancy.php ");

        $pathFile = base_path('config/tenancy.php');

        $configContent = $this->finder->get($pathFile);

        $content = $this->getContentForStub($data, $systemName, $organization,base_path('Modules/Workshop/Scaffold/Module/stubs/config-layout-tenant.stub'));
        $configContent = str_replace('//append-config-layout', $content, $configContent);
       
        $this->finder->put($pathFile, $configContent);

    }

    protected function getContentForStub(array $data, string $systemName, object $organization, $pathStub)
    {
        $stub = $this->finder->get($pathStub);

        return str_replace(
            [
                '$SYSTEM_NAME$',
                '$ORGANIZATION_ID$',
                '$EMAIL$',
                '$PLAN$',
                '$TITLE$',
                '$PASSWORD$',
                '$URL$',
                '$SUPASSWORD$'
            ],
            [
                $systemName,
                $organization->id,
                $data['email'],
                $data['plan'],
                $data['title'],
                $data['password'],
                $organization->domain,
                $data['supassword'],
            ],
            $stub
        );
       

    }

    /*
    * copy db
    */
    public function copyProcess(string $table, array $data, object $organization)
    {
        
        //Dentro ya se tomaran en cuenta las otras tablas
        if($table=="isite__layouts"){

            //row from database
            $rowIdBase = $data['id'];
           
            //Se busca por system name
            $existRegister = \DB::table($table)->select("id")
            ->where("system_name","=",$data['system_name'])
            ->get();
            
            //Not exist , so insert data
            if(count($existRegister)==0){
                
                // El registro no existe, pero el ID de esa Pagina ya sta ocupado en el new tenant    
                unset($data['id']);

                //Insert and get Id
                $newId = \DB::table($table)->insertGetId($data);

                //Process to Copy Translations
                $this->copyTranslations($rowIdBase, $newId);

            }

        }

    }

    /*
    * Part of copy proccess
    */
    public function copyTranslations($rowIdBase,$newId)
    {

        $table = "isite__layout_translations";
        $attName = "layout_id";

        //Search infor in Database Layout
        $dataToCopy = \DB::connection("newConnectionTenant")
        ->select("SELECT * FROM ".$table." WHERE ".$attName." =".$rowIdBase);

        foreach ($dataToCopy as $data) {
            $data = (array)$data;
            // El registro no existe, pero el ID ya sta ocupado en el new tenant
            unset($data['id']);
            $data[$attName] = $newId;
            //Insert
            \DB::table($table)->insert($data);
        }

    }

    /*
    * Updates layouts ids in Central and tenant DB
    */
    public function updateLayoutId(array $data,object $organization)
    {   
        //Si existe el layout, es xq es una copia de otro layout
        if(isset($data["layout"])){

            \Log::info("========== Update Layout Ids ==========");

            //Update in Central Database
            $layoutInCentral = \DB::connection("mysql")->table("isite__layouts")
            ->where("system_name",$data["layout"])
            ->first();

            //Update organization with new layout
            if(!is_null($layoutInCentral)){
                $organization->layout_id = $layoutInCentral->id;
                $organization->save();
            }

            //Update in Tenant Database
            $newLayout= \DB::table("isite__layouts")->select("id")
            ->where("system_name","=",$data['layout'])
            ->first();

            //Update organization with new layout
            if(!is_null($newLayout)){
                \DB::table('isite__organizations')->where('id',$organization->id)
                ->update(['layout_id' => $newLayout->id]);
            }

        }
    }

}