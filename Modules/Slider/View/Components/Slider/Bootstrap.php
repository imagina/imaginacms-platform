<?php


namespace Modules\Slider\View\Components\Slider;
use Illuminate\View\Component;

class Bootstrap extends Component
{

    public $id;
    public $layout;
    public $slider;
    public $view;
    public $height;
    public $dots;
    public $dotsPosition;
    public $dotsStyle;
    public $arrows;
    public $interval;
    public $ride;
    public $pause;
    public $keyboard;
    public $wrap;
    public $touch;
    public $backgroundImg;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $layout = 'slider-bootstrap-layout-1', $height = '500px', $dots = true,
                                $dotsPosition = 'center', $dotsStyle = 'line', $arrows = true, $ride = false,
                                $pause = 'hover', $keyboard = true, $wrap = true, $touch = true, $interval = 5000,
                                $backgroundImg = '' )
    {
        $this->id = $id;
        $this->layout = $layout ?? 'slider-bootstrap-layout-1';
        $this->height = $height ?? '500px';
        $this->arrows = $arrows ?? true;
        $this->dots = $dots ?? true;
        $this->dotsPosition = $dotsPosition ?? 'center';
        $this->dotsStyle = $dotsStyle ?? 'line';
        $this->interval = $interval ?? 5000;
        $this->ride = $ride ?? false;
        $this->pause = $pause ?? 'hover';
        $this->keyboard = $keyboard ?? true;
        $this->wrap = $wrap ?? true;
        $this->touch = $touch ?? true;
        $this->view = "slider::frontend.components.slider.bootstrap.layouts.{$this->layout}.index";
        $this->backgroundImg = $backgroundImg;

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
