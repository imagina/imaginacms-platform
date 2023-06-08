@section('scripts-owl')
  @parent
  <script>
    $(document).ready(function () {
      let vmslider = $('#{{ $slider->system_name }}');
      vmslider.owlCarousel({
        stagePadding: {!!$stagePadding!!},
        items: 1,
        dots: {!! $dots ? 'true' : 'false' !!},
        loop: {!! $loopOwl ? 'true' : 'false' !!},
        lazyLoad: true,
        margin: {!! $margin !!},
        nav: {!! $nav ? 'true' : 'false' !!},
        autoplay: {!! $autoplay ? 'true' : 'false' !!},
        autoplayHoverPause: {!! $autoplayHoverPause ? 'true' : 'false' !!},
        responsiveClass: {!! $responsiveClass ? 'true' : 'false' !!},
        responsive: {!! $responsive!!},
        autoplayTimeout: {{$autoplayTimeout}},
        mouseDrag: {!! $mouseDrag ? 'true' : 'false' !!},
        touchDrag: {!! $touchDrag ? 'true' : 'false' !!},
        {!! !empty($navText) ? 'navText: '.$navText."," : "" !!}
      });
      vmslider.find('.owl-dot').each(function(index) {
        $(this).attr('aria-label', index + 1);
      });
      vmslider.find('.owl-next').attr('aria-label','{{trans('slider::frontend.next')}}');
      vmslider.find('.owl-prev').attr('aria-label','{{trans('slider::frontend.previous')}}');
    });
  </script>
@stop