<?php

namespace Modules\Isite\View\Components;

use Illuminate\View\Component;

class LogoImagina extends Component
{
    public $locale;

    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($classes = null)
    {
        $this->locale = \LaravelLocalization::setLocale() ?? \App::getLocale();
        switch ($this->locale) {
            case 'es':
                $this->type = rand(1, 10);
                break;
            case 'de':
                $this->type = 1;
                break;
            default:
                $this->type = 1;
                $this->locale = 'en';
                break;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('isite::frontend.components.logo-imagina');
    }
}
