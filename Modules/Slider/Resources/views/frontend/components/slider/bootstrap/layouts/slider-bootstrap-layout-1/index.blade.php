<div id="{{ $slider->system_name }}" class="carousel slide slider-component bootstrap-slider-layout-1"
     data-pause="{{ $pause }}" data-ride="{{ $ride }}" data-interval="{{ $interval }}"
     data-keyboard="{{ $keyboard }}" data-wrap="{{ $wrap }}" data-touch="{{ $touch }}">
    @if($dots)
    <ol class="carousel-indicators carousel-indicators-position-{{ $dotsPosition }} carousel-indicators-style-{{ $dotsStyle }}">
        @foreach($slider->slides as $index => $slide)
            <li data-target="#{{ $slider->system_name }}" data-slide-to="{{ $index }}" @if($index === 0) class="active" @endif></li>
        @endforeach
    </ol>
    @endif
    <div class="carousel-inner h-100">
        @foreach($slider->slides as $index => $slide)
            <div class="carousel-item @if($index === 0) active @endif h-100">
                @if($slide->mediaFiles()->slideimage->isVideo)
                    <video class="d-block h-100 slider-img__{{$imgObjectFit}}" width="100%" loop autoplay muted>
                        <source src="{{ $slide->mediaFiles()->slideimage->path }}" />
                    </video>
                @elseif($slide->mediaFiles()->slideimage->isImage)
                    <x-media::single-image :alt="$slide->title ?? Setting::get('core::site-name')"
                                           :title="$slide->title ?? Setting::get('core::site-name')"
                                           :url="$slide->uri ?? $slide->url ?? null" :isMedia="true"
                                           imgClasses="d-block h-100 slider-img__{{$imgObjectFit}}"
                                           width="100%"
                                           :mediaFiles="$slide->mediaFiles()" zone="slideimage"/>
                @else
                    <iframe class="full-height" width="100%" height="{{$height}}" src="{{ $slide->getLinkUrl() }}"
                            frameborder="0" allowfullscreen></iframe>
                @endif
                @if(!empty($slide->title) || !empty($slide->caption) || !empty($slide->custom_html))
                <div class="carousel-caption px-o pb-0 d-none d-md-block h-100">
                    <div class="container h-100">
                        <div class="row h-100 justify-content-center">
                            <div class="col-10 text-center">

                                @if(!empty($slide->title))
                                    <h1 class="title1 mb-2 h1"><b>{{$slide->title}}</b></h1>
                                @endif

                                @if(!empty($slide->custom_html))
                                    <div class="custom-html d-none d-md-block">
                                        {!! $slide->custom_html !!}
                                    </div>
                                @endif

                                <div class="d-block">
                                    <a class="btn btn-primary" href="{{ $slide->url ?? $slide->uri }}">{{ $slide->caption ?? trans('isite::common.menu.viewMore') }}</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        @endforeach
    </div>
    @if($arrows)
        @if(count($slider->slides) > 1)
            <a class="carousel-control-prev" href="#{{$slider->system_name}}" role="button" data-slide="prev">
                <i class="fa fa-angle-left"></i>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#{{$slider->system_name}}" role="button" data-slide="next">
                <i class="fa fa-angle-right"></i>
                <span class="sr-only">Next</span>
            </a>
        @endif
    @endif
</div>
<style>
#{{$slider->system_name}} {
    height: {{$height}};
    overflow: hidden;
}
@media (max-width: 991.98px) {
    #{{$slider->system_name}} {
        height: calc(100vw * (.3)) !important;
    }
}
#{{$slider->system_name}} .image-link {
     display: inline-block;
     height: 100%;
 }
@switch($imgObjectFit)
    @case('fill')
        #{{$slider->system_name}} .slider-img__fill {
             -o-object-fit: fill;
             object-fit: fill;
        }
    @break
    @case('cover')
        #{{$slider->system_name}} .slider-img__cover {
            -o-object-fit: cover;
            object-fit: cover;
        }
    @break
    @case('contain')
        #{{$slider->system_name}} .slider-img__contain {
            -o-object-fit: contain;
            object-fit: contain;
        }
    @break
@endswitch
#{{$slider->system_name}} .carousel-caption {
     padding-top: 15%;
 }
#{{$slider->system_name}} .carousel-caption .title1,
#{{$slider->system_name}} .carousel-caption .custom-html {
     text-shadow: 3px 2px 3px #6c757d;
 }
@if($arrows)
#{{$slider->system_name}} .carousel-control-prev,
#{{$slider->system_name}} .carousel-control-next {
     opacity: 1;
     z-index: 99;
     width: 40px;
     display: block;
     top: 50%;
     position: absolute;
     right: auto;
     left: 0;
     height: 40px;
     margin-top: -20px;
     font-size: 4em;
     color: #fff;
     line-height: 0.5;
 }
#{{$slider->system_name}} .carousel-control-prev i,
#{{$slider->system_name}} .carousel-control-next i {
     line-height: 0.5;
 }
#{{$slider->system_name}} .carousel-control-prev.carousel-control-next,
#{{$slider->system_name}} .carousel-control-next.carousel-control-next {
     right: 0 !important;
     left: auto !important;
 }
#{{$slider->system_name}} .carousel-control-prev:hover,
#{{$slider->system_name}} .carousel-control-next:hover {
     color: var(--primary);
}
@endif
@if($dots)
#{{$slider->system_name}}.owl-with-dots .owl-dots {
     position: absolute;
     bottom: 0;
     left: 0;
     right: 0;
 }
#{{$slider->system_name}}.owl-with-dots.carousel-indicators-position-left .owl-dots,
#{{$slider->system_name}}.owl-with-dots.carousel-indicators-position-right .owl-dots {
     margin: 15px !important;
 }
#{{$slider->system_name}}.owl-with-dots.carousel-indicators-position-right .owl-dots {
     left: auto;
 }
#{{$slider->system_name}}.owl-with-dots.carousel-indicators-position-left .owl-dots {
     right: auto;
}
#{{$slider->system_name}} .carousel-indicators.carousel-indicators-position-left,
#{{$slider->system_name}} .carousel-indicators.carousel-indicators-position-right {
     margin: 15px !important;
}
#{{$slider->system_name}} .carousel-indicators.carousel-indicators-position-right {
     left: auto;
}
#{{$slider->system_name}} .carousel-indicators.carousel-indicators-position-left {
     left: auto;
}
#{{$slider->system_name}}.carousel-indicators-style-square li,
#{{$slider->system_name}}.carousel-indicators-style-square .owl-dots .owl-dot span,
#{{$slider->system_name}} .carousel-indicators-style-square li,
#{{$slider->system_name}} .carousel-indicators-style-square .owl-dots .owl-dot span,
#{{$slider->system_name}}.carousel-indicators-style-circle li,
#{{$slider->system_name}}.carousel-indicators-style-circle .owl-dots .owl-dot span,
#{{$slider->system_name}} .carousel-indicators-style-circle li,
#{{$slider->system_name}} .carousel-indicators-style-circle .owl-dots .owl-dot span {
     width: 11px;
     height: 11px;
     border-radius: 50%;
     margin: 5px;
     border: 2px solid var(--primary);
     background-color: var(--primary);
     position: relative;
     background-clip: border-box;
     opacity: 1;
     flex: 0 1 auto;
}
#{{$slider->system_name}}.carousel-indicators-style-square .owl-dots .owl-dot span,
#{{$slider->system_name}} .carousel-indicators-style-square .owl-dots .owl-dot span,
#{{$slider->system_name}}.carousel-indicators-style-circle .owl-dots .owl-dot span,
#{{$slider->system_name}} .carousel-indicators-style-circle .owl-dots .owl-dot span {
     width: 15px;
     height: 15px;
 }
#{{$slider->system_name}}.carousel-indicators-style-square li.active,
#{{$slider->system_name}}.carousel-indicators-style-square .owl-dots .owl-dot.active span,
#{{$slider->system_name}} .carousel-indicators-style-square li.active,
#{{$slider->system_name}} .carousel-indicators-style-square .owl-dots .owl-dot.active span,
#{{$slider->system_name}}.carousel-indicators-style-circle li.active,
#{{$slider->system_name}}.carousel-indicators-style-circle .owl-dots .owl-dot.active span,
#{{$slider->system_name}} .carousel-indicators-style-circle li.active,
#{{$slider->system_name}} .carousel-indicators-style-circle .owl-dots .owl-dot.active span {
     border: 2px solid #fff;
     background-color: transparent;
 }
#{{$slider->system_name}}.carousel-indicators-style-square li.active:after,
#{{$slider->system_name}}.carousel-indicators-style-square .owl-dots .owl-dot.active span:after,
#{{$slider->system_name}} .carousel-indicators-style-square li.active:after,
#{{$slider->system_name}} .carousel-indicators-style-square .owl-dots .owl-dot.active span:after,
#{{$slider->system_name}}.carousel-indicators-style-circle li.active:after,
#{{$slider->system_name}}.carousel-indicators-style-circle .owl-dots .owl-dot.active span:after,
#{{$slider->system_name}} .carousel-indicators-style-circle li.active:after,
#{{$slider->system_name}} .carousel-indicators-style-circle .owl-dots .owl-dot.active span:after {
     height: 7px;
     width: 7px !important;
     background-color: #fff;
     border-radius: 50%;
     bottom: 2px !important;
     left: 2px !important;
     content: "";
     position: absolute;
 }
#{{$slider->system_name}}.carousel-indicators-style-square li,
#{{$slider->system_name}}.carousel-indicators-style-square .owl-dots .owl-dot span,
#{{$slider->system_name}} .carousel-indicators-style-square li,
#{{$slider->system_name}} .carousel-indicators-style-square .owl-dots .owl-dot span {
     border-radius: 0;
 }
#{{$slider->system_name}}.carousel-indicators-style-square li.active:after,
#{{$slider->system_name}}.carousel-indicators-style-square .owl-dots .owl-dot.active span:after,
#{{$slider->system_name}} .carousel-indicators-style-square li.active:after,
#{{$slider->system_name}} .carousel-indicators-style-square .owl-dots .owl-dot.active span:after {
     border-radius: 0;
 }
#{{$slider->system_name}}.carousel-indicators-style-line li,
#{{$slider->system_name}}.carousel-indicators-style-line .owl-dots .owl-dot span,
#{{$slider->system_name}} .carousel-indicators-style-line li,
#{{$slider->system_name}} .carousel-indicators-style-line .owl-dots .owl-dot span {
     box-sizing: content-box;
     flex: 0 1 auto;
     width: 30px;
     height: 3px;
     margin-right: 3px;
     margin-left: 3px;
     text-indent: -999px;
     cursor: pointer;
     background-color: #fff;
     background-clip: padding-box;
     border-top: 10px solid transparent;
     border-bottom: 10px solid transparent;
     opacity: 0.5;
     transition: opacity 0.6s ease;
     border-radius: 0;
 }
#{{$slider->system_name}}.carousel-indicators-style-line li.active,
#{{$slider->system_name}}.carousel-indicators-style-line .owl-dots .owl-dot.active span,
#{{$slider->system_name}} .carousel-indicators-style-line li.active,
#{{$slider->system_name}} .carousel-indicators-style-line .owl-dots .owl-dot.active span {
     opacity: 1;
}
@endif
</style>