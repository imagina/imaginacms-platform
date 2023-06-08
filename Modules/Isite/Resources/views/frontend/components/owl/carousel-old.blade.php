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
    
                    <?php
                    $hash = sha1($itemComponentNamespace);
                    if (isset($component)) {
                      $__componentOriginal{$hash} = $component;
                    }
                    $component = $__env->getContainer()->make($itemComponentNamespace, array_merge($itemComponentAttributes, [
                      "item" => $items[$x + $j],
                      "positionNumber"=>$x+$j,
                      "layout"=>$itemLayout,
                      "parentAttributes"=>$attributes,
                      "editLink"=>$editLink,
                      "tooltipEditLink"=>$tooltipEditLink
                    ]));
                    $component->withName($itemComponent);
                    if ($component->shouldRender()):
                      $__env->startComponent($component->resolveView(), $component->data());
                      if (isset($__componentOriginal{$hash})):
                        $component = $__componentOriginal{$hash};
                        unset($__componentOriginal{$hash});
                      endif;
                      echo $__env->renderComponent();
                    endif;
                    ?>
                    
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
        stagePadding: {!!$stagePadding!!},
        loop: {!! $loop ? 'true' : 'false' !!},
        lazyLoad: true,
        margin: {!! $margin !!},
        {!! !empty($navText) ? 'navText: '.$navText."," : "" !!}
        dots: {!! $dots ? 'true' : 'false' !!},
        responsiveClass: {!! $responsiveClass ? 'true' : 'false' !!},
        autoplay: {!! $autoplay ? 'true' : 'false' !!},
        autoplayHoverPause: {!! $autoplayHoverPause ? 'true' : 'false' !!},
        autoplayTimeout:{!!$autoplayTimeout!!},
        nav: {!! $nav ? 'true' : 'false' !!},
        center: {!! $center ? 'true' : 'false' !!},
        responsive: {!! $responsive!!}
      });
    });
  </script>
  @parent
@stop
@endif