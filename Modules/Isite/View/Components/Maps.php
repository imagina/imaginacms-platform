<?php

namespace Modules\Isite\View\Components;

use Illuminate\View\Component;
use Modules\Media\Entities\File;
use Modules\Setting\Entities\Setting;

class Maps extends Component
{
//  public $optionMap;
  public $lat;
  public $lng;
  public $title;
  public $locationName;
  public $classes;
  public $zoom;
  public $id;
  public $mapId;
  public $settingMap;
	public $inModal;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($lat, $lng, $locationName = 'Ubicacion', $title = null, $zoom = 16, $classes = '',
                              $id = 1, $mapId = null, $inModal=false)
  {
    $this->lat = $lat;
    $this->lng = $lng;
    $this->locationName = $locationName;
    $this->title = $title;
    $this->zoom = $zoom;
    $this->classes = $classes;
    $this->id = $id;
    $this->mapId = 'map_canvas_' . setting('isite::mapInShow') . '_' . $id;
    $this->settingMap = setting('isite::mapInShow');
$this->inModal=$inModal;
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
