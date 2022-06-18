<?php

namespace Modules\Tag\View\Components;

use Illuminate\View\Component;

class Tags extends Component
{
  public $item;
  public $view;
  public $layout;
  public $buttonClasses;
  public $buttonColor;
  public $buttonSizeLabel;
  public $buttonWithLabel;
  public $titleClass;
  public $buttonStyle;
  public $buttonOnclick;
  public $buttonWithIcon;
  public $buttonIconClass;
  public $buttonTarget;
  public $buttonIconPosition;
  public $buttonIconColor;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($item, $layout = 'tags-layout-1', $buttonClasses = 'btn btn-primary m-1',
                              $buttonColor = 'white', $buttonSizeLabel = '12', $buttonWithLabel = true, $titleClass = 'h5',
                              $buttonStyle = "", $buttonOnclick = "", $buttonWithIcon = false, $buttonIconClass = "",
                              $buttonTarget = "", $buttonIconPosition = "left", $buttonIconColor = 'currentcolor')
  {
    $this->item = $item;
    $this->view = "tag::frontend.components.tags.layouts.{$layout}.index";
    $this->buttonClasses = $buttonClasses;
    $this->buttonColor = $buttonColor;
    $this->buttonSizeLabel = $buttonSizeLabel;
    $this->buttonWithLabel = $buttonWithLabel;
    $this->titleClass = $titleClass;
    $this->buttonStyle = $buttonStyle;
    $this->buttonOnclick = $buttonOnclick;
    $this->buttonWithIcon = $buttonWithIcon;
    $this->buttonIconClass = $buttonIconClass;
    $this->buttonTarget = $buttonTarget;
    $this->buttonIconPosition = $buttonIconPosition;
    $this->buttonIconColor = $buttonIconColor;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public
  function render()
  {
    return view($this->view);
  }
}


