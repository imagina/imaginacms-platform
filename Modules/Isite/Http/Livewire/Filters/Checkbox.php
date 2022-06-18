<?php

namespace Modules\Isite\Http\Livewire\Filters;

use Livewire\Component;
use Illuminate\Support\Str;

class Checkbox extends Component
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
  public $params;

  public $wrapperClasses;
  public $childrenClasses;

  /*
  * Attributes
  */
  protected $options;
  public $selectedOptions;
  public $tagBoxs;

  /*
    * Runs once, immediately after the component is instantiated,
    * but before render() is called
    */
  public function mount($title, $name, $status = true, $isExpanded = true, $type, $repository, $emitTo, $repoAction,
                        $repoAttribute, $listener, $repoMethod = 'getItemsBy', $layout = 'checkbox-layout-1',
                        $classes = 'col-12', $params = [], $wrapperClasses = 'row', $childrenClasses = 'col-12', $tagBoxs = true)
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
    $this->repoMethod = $repoMethod ?? 'getItemsBy';
    $this->layout = $layout;
    $this->classes = $classes;
    $this->params = $params;

    $this->wrapperClasses = $wrapperClasses;
    $this->childrenClasses = $childrenClasses;
    $this->tagBoxs = $tagBoxs;

    $this->selectedOptions = [];
    // Testing
    //\Log::info("NAME: ".$this->name."- GET DATA PARAMS:".json_encode($params));

    $this->selectedOptions = $params["filter"][$this->repoAttribute] ?? [];


  }

  /*
  * When an Option has been selected
  *
  */
  public function updatedSelectedOptions()
  {


    $this->emit($this->emitTo, [
      'name' => $this->name,
      $this->repoAction => [
        $this->repoAttribute => array_values($this->selectedOptions)
      ]
    ]);

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
  public function getData($params)
  {
    

    // Params From Config
    if (!empty($this->params))
      $params = array_replace_recursive($params, $this->params);

    //\Log::info("NAME: ".$this->name."- PARAMS:".json_encode($params));

    $this->options = $this->getRepository()->{$this->repoMethod}(json_decode(json_encode($params)));

    if ($this->options->isNotEmpty() && Str::contains($this->repository, "Category"))
      $this->options = $this->options->toTree();
    //dd($this->options);
  }

  /*
  * Listener
  * Filter Clear Values
  */
  public function clearValues()
  {
    $this->selectedOptions = [];
  }

  /*
  * Render
  *
  */
  public function render()
  {

    // Not Listener, get options
    if (empty($this->listener)) {
      $this->getData($this->params);
    }

    // Validation to Is Expanded
    $count = count(array_intersect($this->options ? $this->options->pluck("id")->toArray() : [], $this->selectedOptions));

    if ($count) $this->isExpanded = true;


    $tpl = 'isite::frontend.livewire.filters.checkbox.layouts.' . $this->layout . '.index';

    $ttpl = $this->layout;
    if (view()->exists($ttpl))
      $tpl = $ttpl;

    //return view($tpl,['options' => $this->options]);
    return view($tpl);

  }

}