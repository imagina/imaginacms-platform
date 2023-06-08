@if(count($slider->slides)==1)
        @php
                $mouseDrag=false;
                $touchDrag=false;
                $dots=false;
                $nav=false;
                $navText=[];
        @endphp
@endif
<div id="{{ $slider->system_name }}Slider">
<div id="{{ $slider->system_name }}"
     class="owl-carousel owl-theme owl-slider-layout-5 {{ $nav ? ' owl-with-nav carousel-nav-position-'.$navPosition : '' }} {{ $dots ? ' owl-with-dots carousel-indicators-position-'.$dotsPosition.' carousel-indicators-style-'. $dotsStyle: '' }} position-relative">
    @foreach($slider->slides as $index => $slide)
        @if($isMobile)
            @if($slide->responsive != 2)
                <div class="slide">
                    @if(!empty($itemComponentAttributes['viewMoreButtonLabel']))
                        @php
                            $itemComponentAttributes['viewMoreButtonLabel'] = $slide->caption ?? trans('isite::common.menu.viewMore');
                        @endphp
                    @else
                        @php
                            $itemComponentAttributes += ['viewMoreButtonLabel' => $slide->caption ?? trans('isite::common.menu.viewMore') ];
                        @endphp
                    @endif
                    @include("isite::frontend.partials.item",["item" => $slide, "itemLayout" => $itemComponentAttributes['layout'],"itemComponentAttributes" => $itemComponentAttributes])
                </div>
            @endif
        @else
            @if($slide->responsive != 3)
                <div class="slide">
                    @if(!empty($itemComponentAttributes['viewMoreButtonLabel']))
                        @php
                            $itemComponentAttributes['viewMoreButtonLabel'] = $slide->caption ?? trans('isite::common.menu.viewMore');
                        @endphp
                    @else
                        @php
                            $itemComponentAttributes += ['viewMoreButtonLabel' => $slide->caption ?? trans('isite::common.menu.viewMore') ];
                        @endphp
                    @endif
                    @include("isite::frontend.partials.item",["item" => $slide, "itemLayout" => $itemComponentAttributes['layout'],"itemComponentAttributes" => $itemComponentAttributes])
                </div>
            @endif
        @endif
    @endforeach
</div>
</div>
@include("slider::frontend.components.slider.owl.script")
@include("slider::frontend.components.slider.owl.layouts.slider-owl-layout-5.style")