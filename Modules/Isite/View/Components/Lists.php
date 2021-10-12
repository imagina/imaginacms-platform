<?php

namespace Modules\Isite\View\Components;

use Illuminate\View\Component;

class Lists extends Component
{


  public $items;
  public $view;
  public $itemLayout;
  public $id;
  public $class;
  public $repository;
  public $layout;
  public $title;
  public $subTitle;
  public $params;
  public $margin;
  public $buttonTitle;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($repository, $class = null, $params = [], $id = 'lists', $buttonTitle = 'Ver Más', $margin = 10, $layout = 'lists-layout-1', $title = "", $subTitle = "")
  {

    $this->id = $id ?? 'itemList';
    $this->margin = $margin;
    $this->repository = $repository;
    $this->params = $params;
    $this->layout = $layout ?? 'item-list-layout-1';
    $this->title = $title;
    $this->subTitle = $subTitle;
    $this->class = $class;
    $this->buttonTitle = $buttonTitle ?? 'Ver más';

    $this->view = "isite::frontend.components.lists.layouts.{$this->layout}.index";

    $this->getItems();
  }

  private function makeParamsFunction(){

    return [
      "include" => $this->params["include"] ?? [],
      "take" => $this->params["take"] ?? 12,
      "page" => $this->params["page"] ?? 1,
      "filter" => $this->params["filter"] ?? [],
      "order" => $this->params["order"] ?? null
    ];
  }

  private function getItems(){

    $this->items = app($this->repository)->getItemsBy(json_decode(json_encode($this->makeParamsFunction())));

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
