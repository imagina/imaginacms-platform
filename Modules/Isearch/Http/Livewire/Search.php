<?php

namespace Modules\Isearch\Http\Livewire;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Iblog\Repositories\PostRepository;
use Modules\Isearch\Transformers\SearchItemTransformer;

class Search extends Component
{
    public $view;
    public $search;
    public $defaultView;
    public $params;
    public $results;
    public $showModal;
    public $icon;
    public $placeholder;
    public $title;
    public $minSearchChars;

    protected $queryString = [
        'search' => ['except' => ''],
    ];


    public function mount($layout = 'search-layout-1', $showModal = false, $icon = 'fa fa-search', $placeholder = null, $title = '', $params = [])
    {
        $this->defaultView = 'isearch::frontend.livewire.search.layouts.search-layout-1.index';
        $this->view = isset($layout) ?'isearch::frontend.livewire.search.layouts.'.$layout.'.index' : $this->defaultView;
        $this->results = [];
        $this->showModal = isset($showModal) ? $showModal : false;
        $this->icon = isset($icon) ? $icon :'fa-search';
        $this->placeholder = $placeholder ?? trans('isearch::common.form.search_here');
        $this->title = $title;
        $minSearchChars = setting('isearch::minSearchChars',null,"3");
        $this->minSearchChars = $minSearchChars;

    }

    private function makeParamsFunction(){
        return [
            "include" => $this->params["include"] ?? ['category'],
            "take" => $this->params["take"] ?? 12,
            "page" => $this->params["page"] ?? false,
            "filter" => $this->params["filter"] ?? ["search" => $this->search, "locale" => \App::getLocale()],
            "order" => $this->params["order"] ?? null,
        ];
    }

    public function render()
    {

        $params = $this->makeParamsFunction();

        $validatedData = Validator::make(
            ['search' => $this->search],
            ['search' => 'required|min:'.$this->minSearchChars],
        );

        if($this->search) {

            if ($validatedData->fails()) {
                $this->results = [];
                $this->alert('error', trans('isearch::common.index.Not Valid',["minSearchChars" => $this->minSearchChars]), config("asgard.isite.config.livewireAlerts"));
            } else {


                if (is_module_enabled('Iblog')) {

                    $this->results = SearchItemTransformer::collection($this->postRepository()->getItemsBy(json_decode(json_encode($params))));
                }

                if (is_module_enabled('Icommerce')) {
                    $products = SearchItemTransformer::collection($this->productRepository()->getItemsBy(json_decode(json_encode($params))));
                    if (is_module_enabled('Iblog')) {
                        $this->results = $this->results->concat($products);
                    } else {
                        $this->results = $products;
                    }
                }

                $results = collect(json_decode(json_encode($this->results->jsonSerialize())));

                $this->results = $results->sortBy('title')->toArray();

                //dd($this->results);

            }
        }
     // dd($this->results);
        return view($this->view);

    }

    public function goToIndex(){
      $locale = LaravelLocalization::setLocale() ?: \App::getLocale();
      $routeLink = config('asgard.isearch.config.route','isearch.search');
      $rl = $routeLink;
      if(!empty($this->search)) {
          if(!Route::has($rl)){ //if route does not exist without locale, pass route with locale
              $rl = $locale.'.'.$routeLink;
          }
          if(!Route::has($rl)){ //if route with locale does not exist either, pass the isearch default route
              $rl = $locale.'.isearch.search';
          }
          $this->redirect(\URL::route($rl) . '?search=' . $this->search);
      }
    }

    /**
     * @return productRepository
     */
    private function productRepository()
    {
        return app('Modules\Icommerce\Repositories\ProductRepository');
    }

    /**
     * @return PostRepository
     */
    private function postRepository()
    {
        return app('Modules\Iblog\Repositories\PostRepository');
    }

}
