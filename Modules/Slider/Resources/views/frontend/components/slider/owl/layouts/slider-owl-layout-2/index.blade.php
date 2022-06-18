<div id="{{ $slider->system_name }}"
     class="owl-carousel owl-theme owl-slider-layout-2 {{ $dots ? ' owl-with-dots carousel-indicators-position-'.$dotsPosition.' carousel-indicators-style-'. $dotsStyle: '' }} position-relative">
  @foreach($slides as $index => $slide)
    @if($slide->active)
      <div class="card border-0">
        <x-isite::edit-link link="{{$editLink}}{{$slider->id}}/?edit={{$slide->id}}"
                            tooltip="{{$tooltipEditLink}}"/>
        <div class="row no-gutters">
          <div class="col-lg-6 ">
            <div class="h-100 position-relative">
              <x-media::single-image :alt="$slide->title ?? Setting::get('core::site-name')"
                                     :title="$slide->title ?? Setting::get('core::site-name')"
                                     :url="$slide->uri ?? $slide->url ?? null" :isMedia="true"
                                     imgClasses="cover-img slider-img__{{$imgObjectFit}}"
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
  @endforeach
</div>
@include("slider::frontend.components.slider.owl.script")
