<?php

namespace Modules\Isite\View\Components;

use Illuminate\View\Component;
use Modules\Media\Entities\File;
use Modules\Setting\Entities\Setting;

class SiteLocation extends Component
{
  public $lat;
  public $lng;
  public $title;
  public $locationName;
  public $classes;
  public $zoom;
  public $settingLocationMap;
  public $mapId;
  public $settingMap;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($title = null, $zoom = 16, $classes = 'SiteLocation')
  {
    $this->title = $title;
    $this->zoom = $zoom;
    $this->classes = $classes;
    $this->mapId = 'map_canvas_'.setting('isite::mapInShow').'SiteLocation';
    $this->settingLocationMap = json_decode(setting('isite::locationSite'));
    $this->lat = $this->settingLocationMap->lat;
    $this->lng = $this->settingLocationMap->lng;
    $this->locationName = @setting('core::site-name');
    $this->settingMap = setting('isite::mapInShow');

  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public
  function render()
  {
    return view("isite::frontend.components.maps");
  }
}
