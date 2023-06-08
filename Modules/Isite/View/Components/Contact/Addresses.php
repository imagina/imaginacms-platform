<?php

namespace Modules\Isite\View\Components\Contact;

use Illuminate\View\Component;

use Modules\Setting\Entities\Setting;

class Addresses extends Component
{
  public $addresses;
  public $icon;
  public $showIcon;
  public $central;
  public $classes;
  public $withHyphen;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($icon = "fa fa-map-marker", $showIcon = true, $addresses = null,
                              $central = false, $classes = null, $withHyphen = true)
  {
    $this->icon = $icon;
    $this->showIcon = $showIcon;
    $this->classes = $classes ?? "";
    $this->withHyphen = $withHyphen;
    if (!empty($addresses)) {
      $this->addresses = !is_array($addresses) ? [$addresses] : $addresses;
    } else {
      $this->addresses = json_decode(setting('isite::addresses', null, "[]", $central));
    }

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
