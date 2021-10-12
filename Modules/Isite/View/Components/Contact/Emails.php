<?php

namespace Modules\Isite\View\Components\Contact;

use Illuminate\View\Component;

class Emails extends Component
{
  public $emails;
  public $icon;
  public $showIcon;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($icon = "fa fa-envelope", $showIcon = true, $emails = null)
  {
    $this->icon = $icon;
    $this->showIcon = $showIcon;
    if(!empty($emails)){
      $this->emails = !is_array($emails) ? [$emails] : $emails;
    }else
      $this->emails = json_decode(setting("isite::emails", null, "[]"));
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
