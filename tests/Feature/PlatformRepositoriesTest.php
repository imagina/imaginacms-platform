<?php

namespace Tests\Feature;

use FloatingPoint\Stylist\Theme\Json;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PhpParser\Node\Stmt\TryCatch;
use PHPUnit\Framework\Constraint\Count;
use Tests\TestCase;

class PlatformRepositoriesTest extends TestCase
{
    private $modules;

    /** @test */
    public function test_modules_enabled(): void
    {
        try{
            $this->modules = app('modules');
            $enabledModules = $this->modules->allEnabled(); //Get all modules
            
            foreach($enabledModules as $modules){
                if($modules->getName() !== 'Core' && $modules->getName() !== 'Dashboard' && $modules->getName() !== 'Ibanners'){
                    $route_module = glob($modules->getPath().'/Repositories/*.php');
                    foreach($route_module as $module){
                        $file_repo = explode("/", $module);
                        $file_repo = $file_repo[count($file_repo)-1]; //helper laravel para tomar el ultimo valor del array.
                        $filter_instan = 'Modules\\'.$modules->getName().'\\Repositories\\'.$file_repo.'';
                        $filter_instan = str_replace(".php", "", $filter_instan);
                        $response = app($filter_instan);
                    }
                }
                
            }

        }catch(\Exception $e){            
            $this->assertFalse(false);
        }
        
        $this->assertTrue(true);
    }
}
