<div id="{{ $slider->system_name }}"
     class="owl-carousel owl-theme owl-slider-layout-1{{ $dots ? ' owl-with-dots carousel-indicators-position-'.$dotsPosition.' carousel-indicators-style-'. $dotsStyle: '' }} position-relative">
  @foreach($slides as $index => $slide)
    @if($slide->active)
      @if($isMobile)
        @if($slide->responsive != 2)
          @switch($slide->type)
            @case("video")
            <div class="item h-100">
              <x-isite::edit-link link="{{$editLink}}{{$slider->id}}/?edit={{$slide->id}}"
                                  tooltip="{{$tooltipEditLink}}"/>
              @if($slide->mediaFiles()->slideimage->isVideo)
                <video class="d-block h-100 slider-img__{{$imgObjectFit}}" width="100%" loop autoplay muted>
                  <source src="{{ $slide->mediaFiles()->slideimage->path }}"/>
                </video>
              @else
                <iframe class="full-height" width="100%" height="{{$height}}" src="{{ $slide->getLinkUrl() }}"
                        frameborder="0" allowfullscreen></iframe>
              @endif
            </div>
            @break
            @default
            <div class="item h-100">
              <x-isite::edit-link link="{{$editLink}}{{$slider->id}}/?edit={{$slide->id}}"
                                  tooltip="{{$tooltipEditLink}}"/>
              @if($slide->mediaFiles()->slideimage->isVideo)
                <video class="d-block h-100 slider-img__{{$imgObjectFit}}" width="100%" loop autoplay muted>
                  <source src="{{ $slide->mediaFiles()->slideimage->path }}"/>
                </video>
              @elseif($slide->mediaFiles()->slideimage->isImage)
                <x-media::single-image :alt="$slide->title ?? Setting::get('core::site-name')"
                                       :title="$slide->title ?? Setting::get('core::site-name')"
                                       :url="$slide->uri ?? $slide->url ?? null" :isMedia="true"
                                       imgClasses="d-block h-100 slider-img__{{$imgObjectFit}}"
                                       width="100%" fetchPriority="high"
                                       :mediaFiles="$slide->mediaFiles()" zone="slideimage"/>
              @endif
              @if(!empty($slide->title) || !empty($slide->caption) || !empty($slide->custom_html))
                <div class="carousel-caption px-o pb-0 d-none d-md-block h-100">
                  <div class="{{$container}} h-100">
                    <div class="row h-100 justify-content-center">
                      <div class="col-10 text-center">
                        @if(!empty($slide->title))
                          <a href="{{ $slide->url ?? $slide->uri }}">
                            <h1 class="title1 mb-2 h1">
                              <b>{{$slide->title}}</b>
                            </h1>
                          </a>
                        @endif

                        @if(!empty($slide->custom_html))
                          <div class="custom-html d-none d-md-block">
                            {!! $slide->custom_html !!}
                          </div>
                        @endif

                        @if(!empty($slide->summary))
                          <div class="summary d-none d-md-block">
                            {!! $slide->summary !!}
                          </div>
                        @endif
                        @if(!empty($slide->url)  || !empty($slide->uri))
                          <div class="d-block">
                            <a class="btn btn-primary"
                               href="{{ $slide->url ?? $slide->uri }}">{{ $slide->caption ?? trans('isite::common.menu.viewMore') }}</a>
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            </div>
            @break
          @endswitch
        @endif
      @else
        @if($slide->responsive != 3)
          @switch($slide->type)
            @case("video")
            <div class="item h-100">
              <x-isite::edit-link link="{{$editLink}}{{$slider->id}}/?edit={{$slide->id}}"
                                  tooltip="{{$tooltipEditLink}}"/>
              @if($slide->mediaFiles()->slideimage->isVideo)
                <video class="d-block h-100 slider-img__{{$imgObjectFit}}" width="100%" loop autoplay muted>
                  <source src="{{ $slide->mediaFiles()->slideimage->path }}"/>
                </video>
              @else
                <iframe class="full-height" width="100%" height="{{$height}}" src="{{ $slide->getLinkUrl() }}"
                        frameborder="0" allowfullscreen></iframe>
              @endif
            </div>
            @break
            @default
            <div class="item h-100">
              <x-isite::edit-link link="{{$editLink}}{{$slider->id}}/?edit={{$slide->id}}"
                                  tooltip="{{$tooltipEditLink}}"/>
              @if($slide->mediaFiles()->slideimage->isVideo)
                <video class="d-block h-100 slider-img__{{$imgObjectFit}}" width="100%" loop autoplay muted>
                  <source src="{{ $slide->mediaFiles()->slideimage->path }}"/>
                </video>
              @elseif($slide->mediaFiles()->slideimage->isImage)
                <x-media::single-image :alt="$slide->title ?? Setting::get('core::site-name')"
                                       :title="$slide->title ?? Setting::get('core::site-name')"
                                       :url="$slide->uri ?? $slide->url ?? null" :isMedia="true"
                                       imgClasses="d-block h-100 slider-img__{{$imgObjectFit}}"
                                       width="100%" fetchPriority="high"
                                       :mediaFiles="$slide->mediaFiles()" zone="slideimage"/>
              @endif
              @if(!empty($slide->title) || !empty($slide->caption) || !empty($slide->custom_html))
                <div class="carousel-caption px-o pb-0 d-none d-md-block h-100">
                  <div class="{{$container}} h-100">
                    <div class="row h-100 justify-content-center">
                      <div class="col-10 text-center">
                        @if(!empty($slide->title))
                          <a href="{{ $slide->url ?? $slide->uri }}">
                            <h1 class="title1 mb-2 h1">
                              <b>{{$slide->title}}</b>
                            </h1>
                          </a>
                        @endif

                        @if(!empty($slide->custom_html))
                          <div class="custom-html d-none d-md-block">
                            {!! $slide->custom_html !!}
                          </div>
                        @endif

                        @if(!empty($slide->summary))
                          <div class="summary d-none d-md-block">
                            {!! $slide->summary !!}
                          </div>
                        @endif
                        @if(!empty($slide->url)  || !empty($slide->uri))
                          <div class="d-block">
                            <a class="btn btn-primary"
                               href="{{ $slide->url ?? $slide->uri }}">{{ $slide->caption ?? trans('isite::common.menu.viewMore') }}</a>
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            </div>
            @break
          @endswitch
        @endif
      @endif
    @endif
  @endforeach
</div>
@include("slider::frontend.components.slider.owl.script")
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
@if($nav)
#{{$slider->system_name}} .owl-stage-outer,
#{{$slider->system_name}} .owl-stage,
#{{$slider->system_name}} .owl-item{
    height: 100% !important;
}
#{{$slider->system_name}} .owl-nav {
     position: absolute;
     top: 50%;
     width: 100%;
     text-align: left;
     margin-top: -20px;
}
#{{$slider->system_name}} .owl-nav [class*=owl-] {
     width: 40px;
     height: 40px;
     color: #ffffff;
     font-size: 3em;
     padding: 0 5px;
     line-height: 0.5;
}
#{{$slider->system_name}} .owl-nav [class*=owl-] i {
    line-height: 0.5;
}
#{{$slider->system_name}} .owl-nav [class*=owl-]:hover {
     color: var(--primary);
     background-color: transparent;
}
#{{$slider->system_name}} .owl-nav .owl-next {
    float: right;
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
#{{$slider->system_name}} button:focus {
    outline: 0 !important;
}
</style>