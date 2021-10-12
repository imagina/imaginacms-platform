<?php

namespace Modules\Isite\Http\Livewire\Filters;

use Livewire\Component;

class Range extends Component
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

    /*
    * Attributes
    */
    public $valueMin;
    public $valueMax;
    public $step;
    public $selValueMin;
    public $selValueMax;
    public $show;
    public $emitWithIndividualAtts = true;

	/*
    * Runs once, immediately after the component is instantiated,
    * but before render() is called
    */
	public function mount($title,$name,$status=true,$isExpanded=true,$type,$repository,$emitTo,$repoAction,$repoAttribute,$listener,$repoMethod='getItemsBy',$layout='range-layout-1',$classes='col-12',$params = [],$step = null){

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
        $this->params = $params;
        $this->step = $step ?? 10000;
       
        $this->valueMin = 0;
        $this->valueMax = 1;
        $this->selValueMin = 0;
        $this->selValueMax = 1;
        $this->show = true;

	}


    /**
   * 
   * Update Range BTN
   *
   */
    public function updateRange($data){

        // Testing
        //\Log::info("DATA: ".json_encode($data));
        $this->emitWithIndividualAtts = false;
       
        if(!empty($data["selValueMin"]) && !empty($data["selValueMax"])){
            $this->selValueMin = $data["selValueMin"];
            $this->selValueMax = $data["selValueMax"];
            
            $this->emitToFilter();
        }
       
    }

    /* 
    * When update Selected Price Min
    * 
    */
    public function updatedSelValueMin(){
        
        //\Log::info("FILTER: ".$this->name."- UPDATED SEL PRICE MIN: ".$this->selValueMin);

        if($this->emitWithIndividualAtts)
            $this->emitToFilter();

    }

    /* 
    * When updated Selected Price Max
    * 
    */
    public function updatedSelValueMax(){

        //\Log::info("FILTER: ".$this->name."- UPDATED SEL PRICE MAX: ".$this->selValueMax);
        
        if($this->emitWithIndividualAtts)
            $this->emitToFilter();

    }

    /* 
    * Emit To Filter
    * 
    */
    public function emitToFilter(){

        /**
        * Example: 
        * emitTo = itemsListGetData (To ItemList Listener)
        * repoAction => 'filter' (To Product Repository),
        * repoAttribute = 'priceRange' (To Product Repository),
        */
        $this->emit($this->emitTo,[
            'name' => $this->name,
            $this->repoAction => [
                $this->repoAttribute => [
                    'from' => $this->selValueMin,
                    'to' => $this->selValueMax
                ]
            ]
        ]);
    }

    /*
    * Get Repository
    *
    */
    private function getRepository(){
        return app($this->repository);
    }


    /*
    * Get Listener From Config
    *
    */
    protected function getListeners()
    {
        if(!empty($this->listener)){
            return [ 
                $this->listener => 'getData',
                'updateRange',
                'filtersClearValues' => 'clearValues'
            ];
        }else{
            return ['updateRange','filtersClearValues' => 'clearValues'];
        }
        
    }

    /*
    * Listener 
    * Item List Rendered (Like First Version)
    */
    public function getData($params){

        // Testing
        //\Log::info("GET DATA - PARAMS: ".json_encode($params));
       
        $selectedValues  = $params["filter"][$this->repoAttribute] ?? null;

        $range = $this->getRepository()->{$this->repoMethod}(json_decode(json_encode($params)));

        //Getting the new price range
        $this->valueMin = round($range->minPrice);
        $this->valueMax = round($range->maxPrice);

        //Validating if the user had selected prices 
        if(!empty($selectedValues)){
            $this->selValueMin = $selectedValues["from"];
            $this->selValueMax = $selectedValues["to"]; 
        }else{
            $this->selValueMin = $this->valueMin;
            $this->selValueMax = $this->valueMax;
        }

        //Validating if there is no price range
        if($this->selValueMin==$this->selValueMax && $this->valueMin==$this->selValueMin && $this->valueMax==$this->selValueMax){
            $this->show = false;
        }else{
            $this->show = true;
        }

        if($this->valueMax==0)
            $this->show = false;

        $originalPriceMax = $this->valueMax;

        // Sum Step Because the widget performs a calculation for the range
        $this->valueMax+=intval($this->step);

        // Validating the selected price if the "step" has increased the maximum value
        if($this->selValueMax==$originalPriceMax && $this->selValueMax!=$this->valueMax){
            $this->selValueMax = $this->valueMax;
        }

        // Dispatch Event to FrontEnd JQuery Layout Slider
        $this->dispatchBrowserEvent('filter-prices-updated', [
            'newPriceMin' => $this->valueMin,
            'newPriceMax' => $this->valueMax,
            'newSelValueMin' => $this->selValueMin,
            'newSelValueMax' => $this->selValueMax,
            'step' => $this->step
        ]);
        

    }

    /*
    * Listener 
    * Filter Clear Values
    */
    public function clearValues(){
        $this->selValueMin = 0;
        $this->selValueMax = 1;
    }

    /*
    * Render
    *
    */
    public function render()
    {

        
    	$tpl = 'isite::frontend.livewire.filters.range.layouts.'.$this->layout.'.index';

        $ttpl = $this->layout;
        if (view()->exists($ttpl))
            $tpl = $ttpl;

		return view($tpl);
			
    }

}