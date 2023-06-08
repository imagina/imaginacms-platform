<style>
@if(!empty($itemComponentAttributes['imagePosition']))
    @if($itemComponentAttributes['layout']=="item-list-layout-7" && $itemComponentAttributes['imagePosition']=="1")
        #{{ $slider->system_name }}Slider {
            aspect-ratio: {{$itemComponentAttributes['imageAspect']}};
            @if(!empty($itemComponentAttributes['imageHeight']))
            height: {{$itemComponentAttributes['imageHeight']}};
            @endif
        }
        @if(!is_null($itemComponentAttributes['imageAspectMobile']))
        @media (max-width: 767.98px) {
            #{{ $slider->system_name }}Slider {
                aspect-ratio: {{$itemComponentAttributes['imageAspectMobile']}};
            }
        }
        @endif
    @endif
@endif

{{-- Style Nav --}}
@if($nav)
#{{ $slider->system_name }}.owl-with-nav .owl-nav .owl-prev:focus,
#{{ $slider->system_name }}.owl-with-nav .owl-nav .owl-next:focus {
    outline: 0 !important;
}
#{{ $slider->system_name }}.owl-with-nav .owl-nav .owl-prev:hover,
#{{ $slider->system_name }}.owl-with-nav .owl-nav .owl-next:hover {
    background: transparent;
}
@if($navPosition=='lateral')
#{{ $slider->system_name }}.owl-with-nav .owl-nav {
     margin-top: 0;
}
#{{ $slider->system_name }}.owl-with-nav.carousel-nav-position-lateral .owl-nav .owl-prev,
#{{ $slider->system_name }}.owl-with-nav.carousel-nav-position-lateral .owl-nav .owl-next  {
    position: absolute;
    top: {{$navLateralTop[0]}}%;
    transform: translateY(-{{$navLateralTop[0]}}%);
}
#{{ $slider->system_name }}.owl-with-nav.carousel-nav-position-lateral .owl-nav .owl-prev {
     left: {{$navLateralLeftRight}};
}
#{{ $slider->system_name }}.owl-with-nav.carousel-nav-position-lateral .owl-nav .owl-next  {
     right: {{$navLateralLeftRight}};
     width: auto;
}
@media (max-width: 767.98px) {
    @if(count($navLateralTop)==2)
    #{{ $slider->system_name }}.owl-with-nav.carousel-nav-position-lateral .owl-nav .owl-prev,
    #{{ $slider->system_name }}.owl-with-nav.carousel-nav-position-lateral .owl-nav .owl-next  {
         top: {{$navLateralTop[1]}}%;
         transform: translateY(-{{$navLateralTop[1]}}%);
    }
    @endif
    #{{ $slider->system_name }}.owl-with-nav.carousel-nav-position-lateral .owl-nav .owl-prev {
        left: 15px;
    }
    #{{ $slider->system_name }}.owl-with-nav.carousel-nav-position-lateral .owl-nav .owl-next  {
        right: 15px;
    }
}
@endif
@if($navPosition!='lateral')
#{{ $slider->system_name }}.owl-with-nav .owl-nav {
     position: absolute;
     left: 15px;
     right: 15px;
     display: flex;
     margin-top: 0;
 }
@endif
@if($navPosition=='center-bottom')
#{{ $slider->system_name }}.owl-with-nav.carousel-nav-position-center-bottom .owl-nav {
     justify-content: center;
     bottom: 0;
}
@endif
@if($navPosition=='left-bottom')
#{{ $slider->system_name }}.owl-with-nav.carousel-nav-position-left-bottom .owl-nav {
     justify-content: left;
     bottom: 0;
}
@endif
@if($navPosition=='right-bottom')
#{{ $slider->system_name }}.owl-with-nav.carousel-nav-position-right-bottom .owl-nav {
     justify-content: right;
     bottom: 0;
}
@endif
@endif

{{-- Style Dots --}}
@if($dots)
#{{ $slider->system_name }}.owl-with-dots .owl-dots {
     position: absolute;
     bottom: {{$dotsBottom}};
     left: 10px;
     right: 10px;
}
#{{ $slider->system_name }}.owl-with-dots .owl-dots .owl-dot:focus {
    outline: 0 !important;
}
@if($dotsPosition=='right')
#{{ $slider->system_name }}.owl-with-dots.carousel-indicators-position-right .owl-dots {
    left: auto;
}
@endif
@if($dotsPosition=='left')
#{{ $slider->system_name }}.owl-with-dots.carousel-indicators-position-left .owl-dots {
    right: auto;
}
@endif
@if($dotsPosition=='left-vertical')
#{{ $slider->system_name }}.owl-with-dots.carousel-indicators-position-left-vertical .owl-dots {
     top: 50%;
     right: auto;
     bottom: auto;
     transform: translateY(-50%);
}
#{{ $slider->system_name }}.owl-with-dots.carousel-indicators-position-left-vertical .owl-dots .owl-dot {
    display: block;
}
@endif
@if($dotsPosition=='right-vertical')
#{{ $slider->system_name }}.owl-with-dots.carousel-indicators-position-right-vertical .owl-dots {
     top: 50%;
     left: auto;
     bottom: auto;
     transform: translateY(-50%);
 }
#{{ $slider->system_name }}.owl-with-dots.carousel-indicators-position-right-vertical .owl-dots .owl-dot {
     display: block;
}
@endif
@if($dotsStyle=='line')
#{{ $slider->system_name }}.owl-with-dots.carousel-indicators-style-line .owl-dots .owl-dot span {
     box-sizing: content-box;
     flex: 0 1 auto;
     width: 30px;
     height: 3px;
     margin-right: 3px;
     margin-left: 3px;
     text-indent: -999px;
     cursor: pointer;
     background-color: {{$dotsStyleColor}};
     background-clip: padding-box;
     border-top: 10px solid transparent;
     border-bottom: 10px solid transparent;
     opacity: 0.5;
     transition: opacity 0.6s ease;
     border-radius: 0;
}
#{{ $slider->system_name }}.owl-with-dots.carousel-indicators-style-line .owl-dots .owl-dot.active span {
    opacity: 1;
}
@endif

@if($dotsStyle=='square')
#{{ $slider->system_name }}.owl-with-dots.carousel-indicators-style-square .owl-dots .owl-dot span {
     width: 15px;
     height: 15px;
     border-radius: 0;
     margin: 5px;
     border: 2px solid {{$dotsStyleColor}};
     background-color: {{$dotsStyleColor}};
     position: relative;
     background-clip: border-box;
     opacity: 1;
     flex: 0 1 auto;
}
#{{ $slider->system_name }}.owl-with-dots.carousel-indicators-style-square .owl-dots .owl-dot.active span {
     border: 2px solid {{$dotsStyleColor}};
     background-color: transparent;
}
#{{ $slider->system_name }}.owl-with-dots.carousel-indicators-style-square .owl-dots .owl-dot.active span:after{
     height: 7px;
     width: 7px !important;
     background-color: {{$dotsStyleColor}};
     border-radius: 0;
     bottom: 2px !important;
     left: 2px !important;
     content: "";
     position: absolute;
}
@endif

@if($dotsStyle=='circle')
#{{ $slider->system_name }}.owl-with-dots.carousel-indicators-style-circle .owl-dots .owl-dot span {
     width: 15px;
     height: 15px;
     border-radius: 50%;
     margin: 5px;
     border: 2px solid {{$dotsStyleColor}};
     background-color: {{$dotsStyleColor}};
     position: relative;
     background-clip: border-box;
     opacity: 1;
     flex: 0 1 auto;
 }
#{{ $slider->system_name }}.owl-with-dots.carousel-indicators-style-circle .owl-dots .owl-dot.active span {
     border: 2px solid {{$dotsStyleColor}};
     background-color: transparent;
 }
#{{ $slider->system_name }}.owl-with-dots.carousel-indicators-style-circle .owl-dots .owl-dot.active span:after{
     height: 7px;
     width: 7px !important;
     background-color: {{$dotsStyleColor}};
     border-radius: 50%;
     bottom: 2px !important;
     left: 2px !important;
     content: "";
     position: absolute;
 }
@endif
@endif

@if(!$itemComponentAttributes['withTitle'] && !$itemComponentAttributes['withSummary'] && !$itemComponentAttributes['withCreatedDate'] && !$itemComponentAttributes['withViewMoreButton'] )
#{{ $slider->system_name }} .image-link {
    z-index: 1;
    position: relative;
}
@endif
</style>