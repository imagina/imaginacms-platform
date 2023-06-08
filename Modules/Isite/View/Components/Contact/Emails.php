<?php

namespace Modules\Isite\View\Components\Contact;

use Illuminate\View\Component;

use Modules\Setting\Entities\Setting;

class Emails extends Component
{
  public $emails;
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
  public function __construct($icon = "fa fa-envelope", $showIcon = true, $emails = null,
                              $central = false, $classes = null, $withHyphen = true)
  {
    $this->icon = $icon;
    $this->showIcon = $showIcon;
    $this->classes = $classes ?? "";
    $this->withHyphen = $withHyphen;
    if(!empty($emails)){
      $this->emails = !is_array($emails) ? [$emails] : $emails;
    }else{
      $this->emails = json_decode(setting("isite::emails", null, "[]",$central));
    }
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view('isite::frontend.components.contact.contactemails');
  }
}
