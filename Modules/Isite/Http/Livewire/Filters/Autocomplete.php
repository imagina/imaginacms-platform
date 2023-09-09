<?php

namespace Modules\Isite\Http\Livewire\Filters;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Isearch\Repositories\SearchRepository;

class Autocomplete extends Component
{
    /*
    * Attributes From Config
    */
    public $title;

    public $name;

    public $status;

    public $type;

    public $repository;

    public $listener;

    public $layout;

    public $classes;

    public $options;

    public $params;

    public $emitTo;

    public $repoAction;

    public $repoAttribute;

    public $repoMethod;

    /*
    * Attributes
    */
    public $view;

    public $search;

    public $defaultView;

    protected $results;

    public $showModal;

    public $icon;

    public $placeholder;

    public $minSearchChars;

    public $repositories;

    public $buttonSearch;

    public $updatedSearchFromInput;

    public $goToRouteAlias;

    public $featuredOptions;

    public $searchOptions;

    public $collapsable;
  public $labelButton;
  public $withLabelButton;

    protected $listeners = ['autocompleteChangeCollapsable'];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount($name = null, $layout = 'autocomplete-layout-1', $showModal = false, $icon = 'fa fa-search',
                        $placeholder = null, $title = '', $params = [], $buttonSearch = false, $emitTo = null,
                        $repoAction = null, $repoAttribute = null, $repoMethod = null, $minSearchChars = null,
                        $goToRouteAlias = null, $labelButton = null, $withLabelButton = false)
    {
        $this->defaultView = 'isite::frontend.livewire.filters.autocomplete.layouts.autocomplete-layout-1.index';
        $this->view = isset($layout) ? 'isite::frontend.livewire.filters.autocomplete.layouts.'.$layout.'.index' : $this->defaultView;
        $this->results = [];
        $this->showModal = isset($showModal) ? $showModal : false;
        $this->icon = isset($icon) ? $icon : 'fa-search';
        $this->placeholder = $placeholder ?? trans('isearch::common.form.search_here');
        $this->title = $title;
        $this->name = $name;
        $this->updatedSearchFromInput = false;
        $this->minSearchChars = $minSearchChars ?? setting('isearch::minSearchChars', null, '3');
        $this->buttonSearch = $buttonSearch;
        $this->emitTo = $emitTo;
        $this->repoAction = $repoAction;
        $this->repoAttribute = $repoAttribute;
        $this->repoMethod = $repoMethod;
        $this->goToRouteAlias = $goToRouteAlias;
        $this->params = $params ?? ['filter' => []];
        $this->layout = $layout;
        $this->featuredOptions = [];
    $this->collapsable = "";
    $this->searchOptions = json_decode(setting('isearch::listOptionsSearch',null, "[]"));
    $this->featuredOptions = json_decode(setting('isearch::listFeaturedOptionsSearch',null, "[]"));
    $this->labelButton = $labelButton ?? trans('isite::common.filters.autocomplete.labelButtonSearch');
    $this->withLabelButton = $withLabelButton;
    }

    public function hydrate()
    {
        \Log::info('Autocomplete: HYDRATE');
        $this->results = collect([]);
    }

    /*
 * When SelectedOption has been selected
 */
    public function updatedSearch()
    {
        $this->updatedSearchFromInput = true;
        \Log::info('UpdatedSearch', [$this->emitTo]);
        if (! empty($this->emitTo)) {
            $this->emit($this->emitTo, [
                'name' => $this->name,
                $this->repoAction => [
                    $this->repoAttribute => $this->search ?? null,
                ],
            ]);
        }
    }

    private function makeParamsFunction(): array
    {
        return [
            'include' => $this->params['include'] ?? ['category'],
            'take' => $this->params['take'] ?? 12,
            'page' => $this->params['page'] ?? false,
            'filter' => array_merge_recursive($this->params['filter'], ['search' => $this->search, 'locale' => \App::getLocale()]),
            'order' => $this->params['order'] ?? null,
        ];
    }

    public function render()
    {
        $params = $this->makeParamsFunction();
        $validatedData = Validator::make(
            ['search' => $this->search],
            ['search' => 'required|min:'.$this->minSearchChars]
        );
        if ($this->layout == 'autocomplete-layout-2') {
            $this->results = array_merge_recursive($this->searchOptions, $this->featuredOptions);

            if (! empty($this->search)) {
                $resultBySearch = [];
                foreach ($this->results as $word) {
                    if (Str::contains($word, $this->search)) {
                        array_push($resultBySearch, $word);
                    }
                }
                $this->results = $resultBySearch;
            }
            sort($this->results);
        } else {
            if ($this->search) {
                if ($validatedData->fails()) {
                    $this->alert('error', trans('isearch::common.index.Not Valid', ['minSearchChars' => $this->minSearchChars]), config('asgard.isite.config.livewireAlerts'));
                } else {
                    $this->results = $this->searchRepository()->getItemsBy(json_decode(json_encode($params)));
                }
            }
        }

        return view($this->view, ['results' => $this->results]);
    }

    public function goToIndex()
    {
        $locale = locale();

        $route = $this->goToRouteAlias;
        if (! empty($this->search)) {
            if (! Route::has($route)) { //if route does not exist without locale, pass route with locale
                $route = $locale.'.'.$route;
            }
            if (! Route::has($route)) { //if route with locale does not exist either, pass the isearch default route
                $route = 'isearch.search';
            }

            $this->redirect(LaravelLocalization::localizeUrl(route($route, null, false), $locale).'?search='.$this->search);
        }
    }

    /*
    * Get Listener From Config
    *
    */
    protected function getListeners()
    {
        return ['filtersClearValues' => 'clearValues'];
    }

    public function autocompleteChangeCollapsable($show)
    {
        $this->collapsable = $show == 'show' && $this->collapsable == 'show' ? '' : $show;
    }

    /*
    * Listener
    * Filter Clear Values
    */
    public function clearValues()
    {
        $this->search = null;
    }

    public function collapsableInputClick($word)
    {
        $this->search = $word;
        $this->updatedSearch();
    }

    private function searchRepository(): SearchRepository
    {
        return app('Modules\Isearch\Repositories\SearchRepository');
    }
}
