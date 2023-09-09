<?php

namespace Modules\Isearch\Http\Livewire;

use Livewire\Component;

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

    public $goToRouteAlias;
  public $labelButton;
  public $withLabelButton;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount($layout = 'search-layout-1', $showModal = false, $icon = 'fa fa-search', $placeholder = null,
                        $title = '', $params = [], $minSearchChars = null, $goToRouteAlias = null, $labelButton = null,
                        $withLabelButton = false)
    {
        $this->defaultView = 'isearch::frontend.livewire.search.layouts.search-layout-1.index';
        $this->view = isset($layout) ? 'isearch::frontend.livewire.search.layouts.'.$layout.'.index' : $this->defaultView;
        $this->results = [];
        $this->showModal = isset($showModal) ? $showModal : false;
        $this->icon = isset($icon) ? $icon : 'fa-search';
        $this->placeholder = $placeholder ?? trans('isearch::common.form.search_here');
        $this->title = $title;

        $this->params = $params;
        $this->minSearchChars = $minSearchChars ?? setting('isearch::minSearchChars', null, '3');
        $this->goToRouteAlias = $goToRouteAlias ?? config('asgard.isearch.config.route', 'isearch.search');
        $repos = json_decode(setting('isearch::repoSearch'));
        $this->params['filter']['repositories'] = $this->params['filter']['repositories'] ?? $repos;
    $this->labelButton = $labelButton;
    $this->withLabelButton = $withLabelButton;

    }

    public function render()
    {
        return view($this->view);
    }
}
