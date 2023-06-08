<div id="{{ $slider->system_name }}"
     class="owl-carousel owl-theme owl-slider-layout-3 {{ $dots ? ' owl-with-dots carousel-indicators-position-'.$dotsPosition.' carousel-indicators-style-'. $dotsStyle: '' }} position-relative">
  @foreach($slides as $index => $slide)
    @if($slide->active)
      @if($isMobile)
        @if($slide->responsive != 2)
          <div class="card card-item border-0">
            <div class="row align-items-center">
              <x-isite::edit-link link="{{$editLink}}{{$slider->id}}/?edit={{$slide->id}}"
                                  tooltip="{{$tooltipEditLink}}"/>
              <div class="col-12 bg-image {{$orderClasses["photo"] ?? 'order-0'}} item-image">
                <x-media::single-image :alt="$slide->title ?? Setting::get('core::site-name')"
                                       :title="$slide->title ?? Setting::get('core::site-name')"
                                       :url="$slide->uri ?? $slide->url ?? null" :isMedia="true"
                                       imgClasses="h-100 d-block  slider-img__{{$imgObjectFit}}"
                                       width="100%" fetchPriority="high"
                                       :mediaFiles="$slide->mediaFiles()" zone="slideimage"/>
              </div>
              @if(!empty($slide->title) || !empty($slide->caption) || !empty($slide->custom_html))
                @if(!empty($slide->title))
                  <div class="col-12 item-title {{$orderClasses["title"] ?? 'order-1'}}">
                    <a href="{{ $slide->url ?? $slide->uri }}">
                      <h3 class="title h1">
                        {{$slide->title}}
                      </h3>
                    </a>
                  </div>
                @endif
                @if(!empty($slide->custom_html))
                  <div class="col-12 custom-html {{$orderClasses["summary"] ?? 'order-2'}} item-summary">
                    {!! $slide->custom_html !!}
                  </div>
                @endif
                @if(!empty($slide->url)  || !empty($slide->uri))
                  <div class="col-12 d-block {{$orderClasses["viewMoreButton"] ?? 'order-3'}}  item-view-more-button">
                    <a class="btn btn-primary view-more-button"
                       href="{{ $slide->url ?? $slide->uri }}">{{ $slide->caption ?? trans('isite::common.menu.viewMore') }}</a>
                  </div>
                @endif
              @endif
            </div>
          </div>
        @endif
      @else
        @if($slide->responsive != 3)
          <div class="card card-item border-0">
            <div class="row align-items-center">
              <x-isite::edit-link link="{{$editLink}}{{$slider->id}}/?edit={{$slide->id}}"
                                  tooltip="{{$tooltipEditLink}}"/>
              <div class="col-12 bg-image {{$orderClasses["photo"] ?? 'order-0'}} item-image">
                <x-media::single-image :alt="$slide->title ?? Setting::get('core::site-name')"
                                       :title="$slide->title ?? Setting::get('core::site-name')"
                                       :url="$slide->uri ?? $slide->url ?? null" :isMedia="true"
                                       imgClasses="h-100 d-block  slider-img__{{$imgObjectFit}}"
                                       width="100%" fetchPriority="high"
                                       :mediaFiles="$slide->mediaFiles()" zone="slideimage"/>
              </div>
              @if(!empty($slide->title) || !empty($slide->caption) || !empty($slide->custom_html))
                @if(!empty($slide->title))
                  <div class="col-12 item-title {{$orderClasses["title"] ?? 'order-1'}}">
                    <a href="{{ $slide->url ?? $slide->uri }}">
                      <h3 class="title h1">
                        {{$slide->title}}
                      </h3>
                    </a>
                  </div>
                @endif
                @if(!empty($slide->custom_html))
                  <div class="col-12 custom-html {{$orderClasses["summary"] ?? 'order-2'}} item-summary">
                    {!! $slide->custom_html !!}
                  </div>
                @endif
                @if(!empty($slide->url)  || !empty($slide->uri))
                  <div class="col-12 d-block {{$orderClasses["viewMoreButton"] ?? 'order-3'}}  item-view-more-button">
                    <a class="btn btn-primary view-more-button"
                       href="{{ $slide->url ?? $slide->uri }}">{{ $slide->caption ?? trans('isite::common.menu.viewMore') }}</a>
                  </div>
                @endif
              @endif
            </div>
          </div>
        @endif
      @endif
    @endif
  @endforeach
</div>
@include("slider::frontend.components.slider.owl.script")
<style>
#{{ $slider->system_name }} .bg-image {
    height: 0;
    padding-bottom: 100%;
    position: relative;
    display: block;
    margin-bottom: 15px;
}
#{{ $slider->system_name }} .bg-image img {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
    left: 0;
    top:0;
}
</style>
