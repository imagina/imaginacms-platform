<?php

namespace Modules\Isite\View\Components;

use Illuminate\View\Component;

class Social extends Component
{
  
  
  public $items;
  public $view;
  public $itemLayout;
  public $components;
  public $layout;
  public $type;
  public $customIcons;
  public $id;
  public $position;
  public $size;
  public $whatsappAttributes;
  
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($layout = 'social-layout-1', $type = '', $customIcons = [], $id = 'socialComponent',
                              $position = 'static', $whatsappAttributes = [], $size = 'lg')
  {
    $this->type = $type ?? '';
    $this->view = "isite::frontend.components.social.layouts.{$layout}.index";
    $this->customIcons = $customIcons;
    $this->id = $id ?? 'socialComponent';
    $this->position = $position ?? 'static';
    $this->size = $size ?? 'lg';
    
    //validate whatsapp attributes
    $this->whatsappAttributes = is_array($whatsappAttributes) && count($whatsappAttributes) > 0 ? $whatsappAttributes : ['size' => $this->size, 'type' => $this->type];
    
  }
  
  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|string
   */
  public function render()
  {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
    
    $items = json_decode(setting('isite::socialNetworks',$locale), true);
    
    $this->items = [];
    
    foreach ($items as $key => $value) {
      $this->items[isset($this->customIcons[$key]) ? $this->customIcons[$key] : 'fa fa-' . $key] = $value;
    }
    
    return view($this->view);
  }
}
