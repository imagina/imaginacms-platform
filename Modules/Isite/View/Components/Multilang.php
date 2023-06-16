<?php

namespace Modules\Isite\View\Components;

use Illuminate\View\Component;

class Multilang extends Component
{
    public $itemLayout;

    public $locales;

    public $buttonComponentAtributtes;

    public $buttonDropDownItemComponentAtributtes;

    public $butonComponentNamespace;

    public $butonComponent;

    public $showButton;

    public $longText;

    public $longTextDrop;

    public $imageComponentAtributtes;

    public $imageComponentNamespace;

    public $imageComponent;

    public $showImage;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($layout = 'multilang-layout-1',
                              $butonComponentNamespace = "Modules\Isite\View\Components\Button",
                              $butonComponent = 'isite::Button',
                              $buttonComponentAtributtes = [],
                              $buttonDropDownItemComponentAtributtes = [],
                              $showButton = true,
                              $longText = true,
                              $longTextDrop = true,

                              $imageComponentNamespace = "Modules\Media\View\Components\SingleImage",
                              $imageComponent = 'media::single-image',
                              $imageComponentAtributtes = [],
                              $showImage = true
  ) {
        $this->view = 'isite::frontend.components.multilang.layouts.'.$layout.'.index';
        $this->locales = json_decode(setting('core::locales'));

        $this->butonComponentNamespace = $butonComponentNamespace;
        $this->butonComponent = $butonComponent;
        $this->buttonComponentAtributtes = $buttonComponentAtributtes;
        $this->buttonDropDownItemComponentAtributtes = $buttonDropDownItemComponentAtributtes;
        $this->showButton = $showButton;
        $this->longText = $longText;
        $this->longTextDrop = $longTextDrop;

        $this->imageComponentNamespace = $imageComponentNamespace;
        $this->imageComponent = $imageComponent;
        $this->imageComponentAtributtes = $imageComponentAtributtes;
        $this->showImage = $showImage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view($this->view);
    }
}
