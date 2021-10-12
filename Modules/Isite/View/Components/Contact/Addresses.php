<?php

namespace Modules\Isite\View\Components\Contact;

use Illuminate\View\Component;

class Addresses extends Component
{
  public $addresses;
  public $icon;
  public $showIcon;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($icon = "fa fa-map-marker", $showIcon = true, $addresses = null)
  {
    $this->icon = $icon;
    $this->showIcon = $showIcon;
    if(!empty($addresses)){
      $this->addresses = !is_array($addresses) ? [$addresses] : $addresses;
    }else
      $this->addresses = json_decode(setting("isite::addresses", null, "[]"));

  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view("isite::frontend.components.contact.contactaddresses");
  }
}
