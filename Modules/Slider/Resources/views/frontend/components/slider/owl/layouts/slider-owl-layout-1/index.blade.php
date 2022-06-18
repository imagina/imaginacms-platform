<div id="{{ $slider->system_name }}"
     class="owl-carousel slider-component owl-theme owl-slider-layout-1{{ $dots ? ' owl-with-dots carousel-indicators-position-'.$dotsPosition.' carousel-indicators-style-'. $dotsStyle: '' }} position-relative"
     style="max-height: {{ $height }}">
  @foreach($slides as $index => $slide)
    @if($slide->active)
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
                                   width="100%"
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
  @endforeach
</div>
@include("slider::frontend.components.slider.owl.script")
