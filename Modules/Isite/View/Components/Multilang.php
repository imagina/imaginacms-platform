<?php

namespace Modules\Isite\View\Components;

use Illuminate\View\Component;

class Multilang extends Component
{

    public $itemLayout;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($layout = "multilang-layout-1", $params = [])
  {

    $this->view = "isite::frontend.components.multilang.layouts.$layout.index";
    $this->params = $params;

    $this->getItems();
  }


  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view("isite::frontend.components.multilang");
  }
}