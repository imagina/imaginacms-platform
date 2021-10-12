@if(!$emptyItems)
<section id="{{$id}}" class="{{$owlBlockStyle}}">
    <div class="{{$containerFluid ? 'container-fluid': 'container'}}">
      <div class="row">
        <div class="col-12">
          
          <div class="title-section">
            <h2 class="title">{!! $title !!}</h2>
            <h6 class="subtitle">
              {!! $subTitle !!}
            </h6>
          </div>
          
          <div id="{{$id}}Carousel" class="owl-carousel owl-theme">
            @php($x = 0) {{-- iterador de items --}}
            @php($j = 0) {{-- iterador de itemsBySlide --}}
            @while(isset($items[$x]))
              @php($j = 0)
              @if($itemsBySlide > 1)
                
                <div class="items-by-slide">
                  @endif
                  
                  @while(isset($items[$x + $j]) && $j<$itemsBySlide)
                    
                    <x-dynamic-component :component="$itemComponent" :item="$items[$x + $j]" :product="$items[$x + $j]" :layout="$itemLayout"
                                         :parentAttributes="$attributes" :editLink="$editLink" :tooltipEditLink="$tooltipEditLink"/>
                    
                    @php($j++)
                  @endwhile
                  @if($itemsBySlide > 1)
                </div>
              @endif
              @php($x+=$itemsBySlide)
            @endwhile
          </div>
        </div>
      </div>
    </div>
  </section>

@section('scripts-owl')
  <script type="text/javascript" defer>
    $(document).ready(function () {
      var owl = $('#{{$id}}Carousel');
      
      owl.owlCarousel({
        loop: {!! $loop ? 'true' : 'false' !!},
        lazyLoad: true,
        margin: {!! $margin !!},
        {!! !empty($navText) ? 'navText: '.$navText."," : "" !!}
        dots: {!! $dots ? 'true' : 'false' !!},
        responsiveClass: {!! $responsiveClass ? 'true' : 'false' !!},
        autoplay: {!! $autoplay ? 'true' : 'false' !!},
        autoplayHoverPause: {!! $autoplayHoverPause ? 'true' : 'false' !!},
        nav: {!! $nav ? 'true' : 'false' !!},
        center: {!! $center ? 'true' : 'false' !!},
        responsive: {!! $responsive!!}
      });
      
    });
  </script>
  
  @parent

@stop
@endif