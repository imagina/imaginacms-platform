<div id="{{ $slider->system_name }}"
     class="owl-carousel owl-theme owl-slider-layout-2 {{ $dots ? ' owl-with-dots carousel-indicators-position-'.$dotsPosition.' carousel-indicators-style-'. $dotsStyle: '' }} position-relative">
  @foreach($slides as $index => $slide)
    @if($slide->active)
      @if($isMobile)
        @if($slide->responsive != 2)
          <div class="card border-0">
            <x-isite::edit-link link="{{$editLink}}{{$slider->id}}/?edit={{$slide->id}}"
                                tooltip="{{$tooltipEditLink}}"/>
            <div class="row no-gutters">
              <div class="col-lg-6 ">
                <div class="h-100 position-relative">
                  <x-media::single-image :alt="$slide->title ?? Setting::get('core::site-name')"
                                         :title="$slide->title ?? Setting::get('core::site-name')"
                                         :url="$slide->uri ?? $slide->url ?? null" :isMedia="true"
                                         imgClasses="cover-img slider-img__{{$imgObjectFit}}" fetchPriority="high"
                                         :mediaFiles="$slide->mediaFiles()" zone="slideimage"/>
                </div>
              </div>
              <div class="col-lg-6 ">
                <div class="card-body py-5 cover-image">
                  <div class="row align-items-center">
                    <div class="col-xl-8">
                      @if(!empty($slide->title) || !empty($slide->caption) || !empty($slide->custom_html))
                        @if(!empty($slide->title))
                          <a href="{{ $slide->url ?? $slide->uri }}">
                            <h3 class="title h1">
                              {{$slide->title}}
                            </h3>
                          </a>
                        @endif
                        @if(!empty($slide->custom_html))
                          <div class="custom-html">
                            {!! $slide->custom_html !!}
                          </div>
                        @endif
                        @if(!empty($slide->url)  || !empty($slide->uri))
                          <div class="d-block">
                            <a class="btn btn-primary"
                               href="{{ $slide->url ?? $slide->uri }}">{{ $slide->caption ?? trans('isite::common.menu.viewMore') }}</a>
                          </div>
                        @endif
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif
      @else
        @if($slide->responsive != 3)
          <div class="card border-0">
            <x-isite::edit-link link="{{$editLink}}{{$slider->id}}/?edit={{$slide->id}}"
                                tooltip="{{$tooltipEditLink}}"/>
            <div class="row no-gutters">
              <div class="col-lg-6 ">
                <div class="h-100 position-relative">
                  <x-media::single-image :alt="$slide->title ?? Setting::get('core::site-name')"
                                         :title="$slide->title ?? Setting::get('core::site-name')"
                                         :url="$slide->uri ?? $slide->url ?? null" :isMedia="true"
                                         imgClasses="cover-img slider-img__{{$imgObjectFit}}" fetchPriority="high"
                                         :mediaFiles="$slide->mediaFiles()" zone="slideimage"/>
                </div>
              </div>
              <div class="col-lg-6 ">
                <div class="card-body py-5 cover-image">
                  <div class="row align-items-center">
                    <div class="col-xl-8">
                      @if(!empty($slide->title) || !empty($slide->caption) || !empty($slide->custom_html))
                        @if(!empty($slide->title))
                          <a href="{{ $slide->url ?? $slide->uri }}">
                            <h3 class="title h1">
                              {{$slide->title}}
                            </h3>
                          </a>
                        @endif
                        @if(!empty($slide->custom_html))
                          <div class="custom-html">
                            {!! $slide->custom_html !!}
                          </div>
                        @endif
                        @if(!empty($slide->url)  || !empty($slide->uri))
                          <div class="d-block">
                            <a class="btn btn-primary"
                               href="{{ $slide->url ?? $slide->uri }}">{{ $slide->caption ?? trans('isite::common.menu.viewMore') }}</a>
                          </div>
                        @endif
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif
      @endif
    @endif
  @endforeach
</div>
@include("slider::frontend.components.slider.owl.script")
<style>
#{{ $slider->system_name }} .cover-image {
    background-position: left center;
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;
    min-height: 400px;
}
#{{ $slider->system_name }} .cover-img {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
@media (max-width: 1199.98px) {
    #{{ $slider->system_name }} .cover-img {
        position: relative;
    }
}
</style>