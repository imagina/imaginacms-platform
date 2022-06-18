<?php

namespace Modules\Isite\View\Components;

use Illuminate\View\Component;
use Modules\Media\Entities\File;
use Modules\Setting\Entities\Setting;
class Logo extends Component
{

  public $logo;
  public $to;
  public $zone;
  public $imgClasses;
  public $linkClasses;
  public $central;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($name = "logo1", $to = null, $imgClasses = "", $linkClasses = "", $central = false)
  {

    $this->to = $to ?? \LaravelLocalization::localizeUrl('/');
    $this->zone = "isite::$name";
    $this->imgClasses = $imgClasses;
    $this->linkClasses = $linkClasses;
    $setting = Setting::where("name", $this->zone);
    
    if($central)
      $setting->withoutTenancy()
        ->whereNull("organization_id");
    
    
    $setting= $setting->with('files')->first();
    

     if(isset($setting->id)){
      $this->logo = $setting;
     }
  }


  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view("isite::frontend.components.logo");
  }
}
