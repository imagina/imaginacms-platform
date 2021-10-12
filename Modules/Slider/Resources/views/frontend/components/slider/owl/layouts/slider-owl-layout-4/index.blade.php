<div id="{{ $slider->system_name }}"
     class="owl-carousel owl-theme owl-slider-layout-4 {{ $dots ? ' owl-with-dots carousel-indicators-position-'.$dotsPosition.' carousel-indicators-style-'. $dotsStyle: '' }} position-relative">
  @foreach($slider->slides as $index => $slide)
    <div class="card border-0">
      <x-isite::edit-link link="{{$editLink}}{{$slider->id}}/?edit={{$slide->id}}"
                          tooltip="{{$tooltipEditLink}}"/>
      <div class="row align-items-center">
        <div class="col-lg-6 {{$orderClasses["photo"] ?? 'order-0'}}">
          <div class="bg-image">
            <x-media::single-image :alt="$slide->title ?? Setting::get('core::site-name')"
                                   :title="$slide->title ?? Setting::get('core::site-name')"
                                   :url="$slide->uri ?? $slide->url ?? null" :isMedia="true"
                                   imgClasses="w-100 slider-img__{{$imgObjectFit}}"
                                   :mediaFiles="$slide->mediaFiles()" zone="slideimage"/>
          </div>
        </div>

        <div class="col-lg-6 {{$orderClasses["content"] ?? 'order-1'}}">

          <div class="card-body py-5">

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

              <div class="d-block">
                <a class="btn btn-primary"
                   href="{{ $slide->url ?? $slide->uri }}">{{ $slide->caption ?? trans('isite::common.menu.viewMore') }}</a>
              </div>
            @endif
          </div>

        </div>

      </div>
    </div>
  @endforeach
</div>
@section('scripts-owl')
  @parent
  <script>
    $(document).ready(function () {
      $('#{{ $slider->system_name }}').owlCarousel({
        items: 1,
        dots: {!! $dots ? 'true' : 'false' !!},
        loop: {!! $loop ? 'true' : 'false' !!},
        lazyLoad: true,
        margin: {!! $margin !!},
        nav: {!! $nav ? 'true' : 'false' !!},
        autoplay: {!! $autoplay ? 'true' : 'false' !!},
        autoplayHoverPause: {!! $autoplayHoverPause ? 'true' : 'false' !!},
        responsiveClass: {!! $responsiveClass ? 'true' : 'false' !!},
        responsive: {!! $responsive!!},
        autoplayTimeout: {{$autoplayTimeout}},
        {!! !empty($navText) ? 'navText: '.$navText."," : "" !!}
      });
    });
  </script>
@stop
