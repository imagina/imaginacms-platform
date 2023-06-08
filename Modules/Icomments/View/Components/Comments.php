<?php

namespace Modules\Icomments\View\Components;

use Illuminate\View\Component;

class Comments extends Component
{


  public $view;
  public $items;
  public $params;
  public $model;
  public $approved;
  public $showRating;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($layout = "comments-layout-1", $model, $approved = false, $showRating = true, $params = [])
  {

    $this->view = "icomments::frontend.components.comments.layouts.$layout.index";
    $this->model = $model;
    $this->approved = $approved;
    $this->params = $params;
    $this->showRating = $showRating;

    $this->getItems();
    
  }

  private function getItems(){

    if($this->approved)
      $this->items = $this->model->approvedComments;
    else
      $this->items = $this->model->comments;

  }
  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|string
   */
  public function render()
  {
    return view($this->view);
  }

}