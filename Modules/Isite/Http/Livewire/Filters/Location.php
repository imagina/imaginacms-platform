<?php

namespace Modules\Isite\Http\Livewire\Filters;

use Livewire\Component;

class Location extends Component
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
    public $radio;
    public $startGeolocation;
   
    /*
    * Attributes
    */
    public $lat;
    public $lng;
    public $selectedRadio;
    public $inputSearchLocation;
    public $country;
    public $countryCode;
    public $province;
    public $city;

    /*
    * Attributes To Type "location-2"
    *
    */
    public $options;
    public $selectedOption;
    public $selectedOptionName = "";

	/*
    * Runs once, immediately after the component is instantiated,
    * but before render() is called
    */
	public function mount($title,$name,$status=true,$isExpanded=true,$type="location",$repository,$emitTo,$repoAction,$repoAttribute,$listener,$repoMethod='getItemsBy',$layout='location-layout-1',$classes='col-12', $params = [], $radio = [], $startGeolocation=false){
		
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
        $this->radio = $radio;
        $this->startGeolocation = $startGeolocation;
        
        $this->initValues();
        
	}

    /* 
    * Init Values Attributes
    * 
    */
    public function initValues(){
        $this->lat = 0;
        $this->lng = 0;
        $this->selectedRadio = $this->radio['defaultValue'] ?? 'all';
        $this->inputSearchLocation = "";

        /* Init Values to type 2*/
        if($this->type=="location-2"){

            $this->options = $this->cityRepository()->getItemsBy();

            $optionId = request()->session()->get('cityIdSelected');
            
            if(!empty($optionId)){
                $this->selectedOption = $optionId;
                $this->setValueOptionName();
            }
        }

    }

    /* 
    * When updated Lng Attribute
    * type location
    */
    public function updatedLng(){

        $this->emitToFilter();
    }

    /* 
    * When updated CountryCode Attribute
    * Only Type location-2
    * Just First Request
    */
    public function updatedCountryCode(){

        $option = $this->options->firstWhere('name',strtoupper($this->city));

        if(!empty($option)){
            $this->selectedOption = $option->id;
            $this->selectedOptionName = $option->name;
        }else{
            $this->selectedOption = 0;
            $this->selectedOptionName = trans('isite::frontend.filter-location.all');
        }
        
        if($this->selectedOption!=0)
            $this->emitToFilter();

    }

    /* 
    * When updated selectedRadio Attribute
    * 
    */
    public function updatedSelectedRadio(){

        $this->emitToFilter();
      
    }

    /* 
    * When updated selectedOption Attribute
    * 
    */
    public function updatedSelectedOption(){

        $this->emitToFilter();
      
    }


    /* 
    * Emit To Filter
    * 
    */
    public function emitToFilter(){

        $emitInfor = [];

        if($this->type=="location-2"){

            request()->session()->put('cityIdSelected', $this->selectedOption);

            $this->setValueOptionName();

            $emitInfor = (int)$this->selectedOption;

        }else{

            $emitInfor['country'] = $this->country;
            $emitInfor['province'] = $this->province;
            $emitInfor['city'] = $this->city;
            $emitInfor['radio'] = $this->selectedRadio;
            $emitInfor['lat'] = $this->lat;
            $emitInfor['lng'] = $this->lng;  

        }
        
        // Emit To (config file - parent filter or items list)
        $this->emit($this->emitTo,[
            'name' => $this->name,
            $this->repoAction => [
                $this->repoAttribute => $emitInfor
            ],
            'eventUpdateItemsList' => $this->startGeolocation
        ]);


    }

    /*
    * Set Value Option Name
    *
    */
    private function setValueOptionName($param='id'){

        $option = $this->options->firstWhere($param,strtoupper($this->selectedOption));
        $this->selectedOptionName = $option->name;   
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
    protected function getListeners(){
        if(!empty($this->listener)){
            return [ 
                $this->listener => 'getData', 
                'filtersClearValues' => 'clearValues'
            ];
        }else{
            return [ 'filtersClearValues' => 'clearValues'];
        }
    }

    /*
    * Listener 
    * Item List Rendered
    */
    public function getData($params){

        
    }

    /*
    * Listener 
    * Filter Clear Values
    */
    public function clearValues(){
      
      $this->initValues(); 

    }

    /*
    * City Repository
    */
    private function cityRepository()
    {
        return app('Modules\Ilocations\Repositories\CityRepository');
    }

    /*
    * Render
    *
    */
    public function render()
    {

       
        $tpl = 'isite::frontend.livewire.filters.location.layouts.'.$this->layout.'.index';
       
        $ttpl = $this->layout;
        if (view()->exists($ttpl))
            $tpl = $ttpl;
            
        return view($tpl);
			
    }

}