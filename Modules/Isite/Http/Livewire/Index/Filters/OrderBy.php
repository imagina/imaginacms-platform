<?php

namespace Modules\Isite\Http\Livewire\Index\Filters;

use Livewire\Component;

class OrderBy extends Component
{
	
    // Query Value
    private $order;

    // Wire Model
    public $orderBy;

    public $configs;
    public $type;

    protected $listeners = ['itemListRendered'];

	public function mount($config = null, $type = "select"){

        $this->configs['orderBy'] = $config ?? config("asgard.isite.config.orderBy");

        $this->orderBy = $this->configs['orderBy']['default'] ?? "nameaz";
        $this->order = $this->configs['orderBy']['options'][$this->orderBy]['order'];

        $this->type = $type;
		
	}

    /*
    * Updating Attribute OrderBy
    *
    */
    public function updatedOrderBy(){

        $this->order = $this->configs['orderBy']['options'][$this->orderBy]['order'];

        //\Log::info("EMIT GET DATA: ".json_encode($this->order));

        $this->emit('itemsListGetData',[
          'order' => $this->orderBy
        ]);
      
    }

    /*
    * Listener - Item List Rendered 
    *
    */
    public function itemListRendered($params){
        
        // Testing
        //\Log::info("OrderBy - Item List Rendered - Params: ".json_encode($params));

        $this->orderBy = $params["orderBy"] ?? null;
        $this->order  = $params["order"] ?? null;

    }

    public function render()
    {
        
        $tpl = "isite::frontend.livewire.index.filters.order-by.".$this->type;
		return view($tpl);
			
    }

}