<?php

namespace Modules\Isite\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Ihelpers\Transformers\BaseApiTransformer;
use Illuminate\Support\Str;

class SiteTransformer extends BaseApiTransformer
{
  public function toArray($request)
  {
    $allowedSettings = config('asgard.isite.config.allowedSettings');
    $imageSettings = config('asgard.isite.config.imageSettings');
    $item = [];
    foreach ($allowedSettings as $val){
      if(isset($this->$val))
        if(in_array($val,$imageSettings)){
          $item[$val] =url( '/modules/isite/img/defaultLogo.jpg') .'?'. uniqid();
          
          $path = '/assets/isite/';
          //Get all files from folder of Isite
          $allFiles =  \Storage::disk('publicmedia')->allFiles($path);
          
          
          //Find files with same name
          foreach($allFiles as $key => &$file){
            if(Str::contains($file, $this->$val))
              $item[$val] = url(!empty($this->$val) ? $this->$val : '/modules/isite/img/defaultLogo.jpg') .'?'. uniqid();
            
          }
          
          
        }
        else
          $item[$val] = $this->$val;
    }
    
    return $item;
    
  }
}
