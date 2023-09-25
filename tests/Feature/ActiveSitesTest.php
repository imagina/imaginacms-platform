<?php

namespace Tests\Feature;

use Illuminate\Database\Connectors\MySqlConnector;
use Illuminate\Database\MySqlConnection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Modules\Page\Entities\PageTranslation;
use Modules\Page\Entities\Page;
use Illuminate\Database\Eloquent\Builder;
use Mcamara\LaravelLocalization\LaravelLocalization;

class ActiveSitesTest extends TestCase
{
    

    public function test_sites_active_in_platform(): void
    {
        
        $pages = PageTranslation::where('status', '1')->get();

        $language = json_decode(setting('core::locales', null, '[]'));
        foreach($language as $lang){
            $localePages= $pages->where('locale', $lang);
            foreach($localePages as $page){
                $url = \LaravelLocalization::localizeUrl('/'.$page->slug, $page->locale);
                //echo $url."\r\n";
                $response = $this->get($url);
                $response->assertStatus(200);
                // //dd($response);
                // $statuscode = $response->getStatusCode();
                // //echo($statuscode);
                //  if($statuscode !== 301 && $statuscode !== 404){
                //     echo $url."\r\n";
                //     //continue;
                //  }
                // // }elseif($statuscode == 301){
                // //    echo "Redirect: ".$url."\r\n";
                // //    echo($response->getTargetUrl()."\r\n");
                // //    $response->assertStatus(200);
                    
                // // }else{
                // //    $response->assertStatus(200);
                // // }
            }
        }
        // dd();
        

    }
    
}
