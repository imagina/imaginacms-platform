<?php

namespace Modules\Isite\Http\Livewire\Filters;

use Livewire\Component;

class Text extends Component
{
    public $status;

    public $type;

    public $emitTo;

    public $repoAction;

    public $repoAttribute;

    public $repoMethod;

    public $layout;

    public $classes;

    public $placeholder;

    public $name;

    public $value;

    public $isCollapsable;

    public $isExpanded;

    public $title;

    public function mount($title, $name, $placeholder, $status, $isExpanded, $type, $emitTo, $repoAction,
                        $repoAttribute, $repoMethod = 'getItemsBy', $layout = 'text-layout-1',
                        $classes = 'col-12', $isCollapsable = true)
    {
        $this->status = $status;
        $this->type = $type;
        $this->emitTo = $emitTo;
        $this->repoAction = $repoAction;
        $this->repoAttribute = $repoAttribute;
        $this->repoMethod = $repoMethod;
        $this->layout = $layout;
        $this->classes = $classes;
        $this->placeholder = $placeholder;
        $this->name = $name;
        $this->isCollapsable = $isCollapsable;
        $this->isExpanded = $isExpanded;
        $this->title = $title;
    }

    /*
    * When SelectedOption has been selected
    */
    public function updatedValue()
    {
        $this->emit($this->emitTo, [
            'name' => $this->name,
            $this->repoAction => [
                $this->repoAttribute => $this->value,
            ],
        ]);

        $this->isExpanded = true;
    }

    public function render()
    {
        $tpl = 'isite::frontend.livewire.filters.text.layouts.'.$this->layout.'.index';

        $ttpl = $this->layout;
        if (view()->exists($ttpl)) {
            $tpl = $ttpl;
        }

        return view($tpl);
    }
}
