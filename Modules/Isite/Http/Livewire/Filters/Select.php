<?php

namespace Modules\Isite\Http\Livewire\Filters;

use Livewire\Component;

class Select extends Component
{
  
  /*
  * Attributes From Config
  */
  public $title;
  public $name;
  public $status;
  public $isExpanded;
  public $type;
  public $repository;
  public $emitTo;
  public $repoAction;
  public $repoAttribute;
  public $listener;
  public $repoMethod;
  public $layout;
  public $classes;
  public $options;
  public $selected;
  public $params;
  public $withTitle;
  public $withSubtitle;
  
  /*
  * Attributes
  */
  
  
  /*
    * Runs once, immediately after the component is instantiated,
    * but before render() is called
    */
  public function mount($title, $name, $status = true, $isExpanded = true, $type, $repository, $emitTo, $repoAction,
                        $repoAttribute, $listener, $repoMethod = 'getItemsBy', $layout = 'select-layout-1',
                        $classes = 'col-12', $params = [], $isCollapsable = true, $withTitle = true, $withSubtitle = true)
  {
    
    $this->title = trans($title);
    $this->name = $name;
    $this->status = $status;
    $this->isExpanded = $isExpanded;
    $this->type = $type;
    $this->repository = $repository;
    $this->emitTo = $emitTo;
    $this->repoAction = $repoAction;
    $this->repoAttribute = $repoAttribute;
    $this->listener = $listener;
    $this->repoMethod = $repoMethod;
    $this->layout = $layout;
    $this->classes = $classes;
    $this->isCollapsable = $isCollapsable;
    $this->params = $params;
    $this->selected = null;
    $this->withTitle = $withTitle;
    $this->withSubtitle = $withSubtitle;
    
    $this->getData();
  }
  
  /*
  * Get Repository
  *
  */
  private function getRepository()
  {
    return app($this->repository);
  }
  
  /*
  * Get Listener From Config
  *
  */
  protected function getListeners()
  {
    if (!empty($this->listener)) {
      return [
        $this->listener => 'getData',
        'filtersClearValues' => 'clearValues'
      ];
    } else {
      return ['filtersClearValues' => 'clearValues'];
    }
  }
  
  /*
  * Listener
  * Item List Rendered (Like First Version)
  */
  public function getData($params = [])
  {
  
    // Params From Config
    if (!empty($this->params))
      $params = array_merge_recursive($params, $this->params);
    //\Log::info("NAME: ".$this->name."- PARAMS:".json_encode($params));
  
    $this->options = $this->getRepository()->{$this->repoMethod}(json_decode(json_encode($params)));
  
  }
  
  
  /*
  * When SelectedOption has been selected
  */
  public function updatedSelected()
  {

    $this->emit($this->emitTo, [
      'name' => $this->name,
      $this->repoAction => [
        $this->repoAttribute => $this->selected == "NULL" ? null : $this->selected
      ]
    ]);
    
    $this->isExpanded = true;
  }

  /*
  * Listener
  * Filter Clear Values
  */
  public function clearValues()
  {
    $this->selected = null;
  }
  
  /*
  * Render
  *
  */
  public function render()
  {
    
    
    $tpl = 'isite::frontend.livewire.filters.select.layouts.' . $this->layout . '.index';
    
    $ttpl = $this->layout;
    if (view()->exists($ttpl))
      $tpl = $ttpl;
    
    return view($tpl);
    
  }
  
}