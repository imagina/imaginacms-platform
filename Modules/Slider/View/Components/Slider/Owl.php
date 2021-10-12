<?php


namespace Modules\Slider\View\Components\Slider;
use Illuminate\View\Component;

class Owl extends Component
{

    public $id;
    public $layout;
    public $slider;
    public $view;
    public $height;
    public $margin;
    public $loopOwl; //renamed because the $loop is reserved into de blade @foreach
    public $dots;
    public $dotsPosition;
    public $dotsStyle;
    public $nav;
    public $navText;
    public $autoplay;
    public $autoplayHoverPause;
    public $autoplayTimeout;
    public $containerFluid;
    public $imgObjectFit;
    public $responsive;
    public $responsiveClass;
    public $orderClasses;
    public $editLink;
    public $tooltipEditLink;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $layout = 'slider-owl-layout-1', $height = '500px', $autoplay = true, $margin = 0,
                                $autoplayHoverPause = true, $loop = true, $dots = true, $dotsPosition = 'center',
                                $dotsStyle = 'line', $nav = true, $navText = "", $autoplayTimeout = 5000, $imgObjectFit="cover",
                                $responsiveClass = false, $responsive = null, $orderClasses = [])
    {
        $this->id = $id;
        $this->layout = $layout ?? 'slider-owl-layout-1';
        $this->height = $height ?? '500px';
        $this->margin = $margin ?? 0;
        $this->dots = $dots ?? true;
        $this->dotsPosition = $dotsPosition ?? 'center';
        $this->dotsStyle = $dotsStyle ?? 'line';
        $this->nav = $nav ?? true;
        $this->navText = json_encode($navText);
        $this->loopOwl = $loop ?? true;
        $this->autoplay = $autoplay ?? true;
        $this->autoplayHoverPause = $autoplayHoverPause ?? true;
        $this->autoplayTimeout = $autoplayTimeout ?? 5000;
        $this->imgObjectFit = $imgObjectFit ?? "cover";
        $this->responsive = json_encode($responsive ?? [0 => ["items" =>  1]]);
        $this->responsiveClass = $responsiveClass;
        $this->orderClasses = !empty($orderClasses) ? $orderClasses : ["photo" => "order-0", "content" => "order-1"];
        list($this->editLink, $this->tooltipEditLink) = getEditLink('Modules\Slider\Repositories\SlideRepository');


        $this->view = "slider::frontend.components.slider.owl.layouts.{$this->layout}.index";

        $this->getItem();
    }

    public function getItem(){
        $params = [
            'filter' => [
                'field' => 'id',
            ],
            'include' => ['slides']
        ];

        $this->slider = app('Modules\\Slider\\Repositories\\SliderApiRepository')->getItem($this->id, json_decode(json_encode($params)));
        if(!$this->slider){
            $params['filter']['field'] = 'system_name';
            $this->slider = app('Modules\\Slider\\Repositories\\SliderApiRepository')->getItem($this->id, json_decode(json_encode($params)));
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view($this->view);
    }
}
