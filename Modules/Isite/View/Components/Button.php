<?php

namespace Modules\Isite\View\Components;

use Illuminate\View\Component;

class Button extends Component
{

  public $idButton;
  public $style;
  public $buttonClasses;
  public $onclick;
  public $withIcon;
  public $iconClass;
  public $iconPosition;
  public $iconColor;
  public $withLabel;
  public $label;
  public $href;
  public $color;
  public $target;
  public $sizeLabel;
  public $dataItemId;
  
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($idButton = null, $style = "", $buttonClasses = "", $onclick="", $withIcon = false, $iconClass = "",
                              $withLabel = false, $label = "", $href = "",  $color="primary",
                              $target="", $iconPosition="left", $iconColor='currentcolor', $sizeLabel="16", $dataItemId="" )
  {
    $this->idButton = $idButton ?? uniqid('button');
    $this->style = $style;
    $this->buttonClasses = $buttonClasses;
    $this->onclick = $onclick;
    $this->withIcon = $withIcon;
    $this->iconClass = $iconClass;
    $this->iconPosition = $iconPosition;
    $this->iconColor = $iconColor;
    $this->withLabel = $withLabel;
    $this->label = $label;
    $this->href = $href;
    $this->color = $color;
    $this->target = $target;
    $this->sizeLabel = $sizeLabel;
    $this->dataItemId =  $dataItemId;
  }


  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view("isite::frontend.components.button");
  }
}
