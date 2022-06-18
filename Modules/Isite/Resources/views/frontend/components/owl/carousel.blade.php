@if(!$emptyItems)
  <section id="{{$id}}" class="{{$owlBlockStyle}}">
    <div class="{{$containerFluid ? 'container-fluid': 'container'}}">

      <div class="row align-items-center @if($navPosition=='top-right') justify-content-end @endif @if(($navPosition=="top-right" || $navPosition=="top-left") && $owlTextAlign=="text-center") my-3 @endif">

        <div class="col px-0 {{ $navPosition=="top-left" ? 'order-1':'' }}"  @if(($navPosition=="top-right" || $navPosition=="top-left") && $owlTextAlign=="text-center") style="position: absolute; left: 0;" @endif>
          <div class="title-section {{$owlTextAlign}}" @if($owlTextPosition==3) style="display: flex; flex-direction: column;" @endif>
            @if($title!=="")
              @if($owlTitleUrl)
              <a href="{{$owlTitleUrl}}" target="{{$owlTitleTarget}}" style="text-decoration: none;">
              @endif
              <h2 class="title {{ $owlTextPosition==3 ? 'order-1':'' }} {{$owlTitleColor}} {{$owlTitleWeight}} {{$owlTitleTransform}} {{$owlTitleMarginT}} {{$owlTitleMarginB}}" style="font-size: {{$owlTitleSize}}px;">
                @if($owlTitleVineta) <i class="{{$owlTitleVineta}} {{$owlTitleVinetaColor}} mr-1"></i>  @endif
                <span> {!! $title !!}</span>
              </h2>
              @if($owlTitleUrl)
              </a>
              @endif
            @endif
            @if($subTitle!=="" && $owlTextPosition!=1)
              <h6 class="subtitle {{$owlSubtitleColor}} {{$owlSubtitleWeight}} {{$owlSubtitleTransform}} {{$owlSubtitleMarginT}} {{$owlSubtitleMarginB}}" style="font-size: {{$owlSubtitleSize}}px;">
                {!! $subTitle !!}
              </h6>
            @endif
          </div>
        </div>

        @if($nav && $navPosition=="top-left" || $nav && $navPosition=="top-right")
          <div class="col-auto {{ $navPosition=="top-left" ? 'order-0 pl-0': 'pr-0' }}">

            <x-isite::button :style="$navStyleButton"
                             :buttonClasses="'prevBtn d-inline-block my-2  '.$navSizeButton.' '.$navStyleButton"
                             :withIcon="true"
                             :iconClass="'fa fa-'.$navIcon.'-left'"
                             :withLabel="false"
                             :color="$navColor"
                             :sizeLabel="$navSizeLabel"
            />

            <x-isite::button :style="$navStyleButton"
                             :buttonClasses="'nextBtn d-inline-block my-2  '.$navSizeButton.' '.$navStyleButton"
                             :withIcon="true"
                             :iconClass="'fa fa-'.$navIcon.'-right'"
                             :withLabel="false"
                             :color="$navColor"
                             :sizeLabel="$navSizeLabel"
            />
          </div>
        @endif
      </div>


      @if($nav && $navPosition=="top-center")
        <div class="text-center">

          <x-isite::button :style="$navStyleButton"
                           :buttonClasses="'prevBtn d-inline-block my-2 '.$navSizeButton.' '.$navStyleButton"
                           :withIcon="true"
                           :iconClass="'fa fa-'.$navIcon.'-left'"
                           :withLabel="false"
                           :color="$navColor"
                           :sizeLabel="$navSizeLabel"
          />

          <x-isite::button :style="$navStyleButton"
                           :buttonClasses="'nextBtn d-inline-block my-2  '.$navSizeButton.' '.$navStyleButton"
                           :withIcon="true"
                           :iconClass="'fa fa-'.$navIcon.'-right'"
                           :withLabel="false"
                           :color="$navColor"
                           :sizeLabel="$navSizeLabel"
          />


        </div>
      @endif



      @if($nav && $navPosition=="center")
        <div class="wrapper">
          <div>

            <x-isite::button :style="$navStyleButton"
                             :buttonClasses="'prevBtn d-inline-block my-2  '.$navSizeButton.' '.$navStyleButton"
                             :withIcon="true"
                             :iconClass="'fa fa-'.$navIcon.'-left'"
                             :withLabel="false"
                             :color="$navColor"
                             :sizeLabel="$navSizeLabel"
            />
          </div>

          @endif

          <div class=" @if($navPosition!="center") row  py-3 @endif">
            <div id="{{$id}}Carousel" class="owl-carousel owl-theme {{$dotsStyle}}">
              @php($x = 0) {{-- iterador de items --}}
              @php($j = 0) {{-- iterador de itemsBySlide --}}
              @while(isset($items[$x]))
                @php($j = 0)
                @if($itemsBySlide > 1)

                  <div class="items-by-slide">
                    @endif

                    @while(isset($items[$x + $j]) && $j<$itemsBySlide)
    
                      @include("isite::frontend.partials.item",["item" => $items[$x + $j], "position" => $x + $j])

                      @php($j++)
                    @endwhile
                    @if($itemsBySlide > 1)
                  </div>
                @endif
                @php($x+=$itemsBySlide)
              @endwhile
            </div>
          </div>

          @if($nav && $navPosition=="center")
            <div>
              <x-isite::button :style="$navStyleButton"
                               :buttonClasses="'nextBtn d-inline-block my-2  text-right '.$navSizeButton.' '.$navStyleButton"
                               :withIcon="true"
                               :iconClass="'fa fa-'.$navIcon.'-right'"
                               :withLabel="false"
                               :color="$navColor"
                               :sizeLabel="$navSizeLabel"
              />

            </div>
        </div>
      @endif


      @if($nav && $navPosition=="bottom")
        <div class="text-center">

          <x-isite::button :style="$navStyleButton"
                           :buttonClasses="'prevBtn d-inline-block my-2 '.$navSizeButton.' '.$navStyleButton"
                           :withIcon="true"
                           :iconClass="'fa fa-'.$navIcon.'-left'"
                           :withLabel="false"
                           :color="$navColor"
                           :sizeLabel="$navSizeLabel"
          />

          <x-isite::button :style="$navStyleButton"
                           :buttonClasses="'nextBtn d-inline-block my-2  '.$navSizeButton.' '.$navStyleButton"
                           :withIcon="true"
                           :iconClass="'fa fa-'.$navIcon.'-right'"
                           :withLabel="false"
                           :color="$navColor"
                           :sizeLabel="$navSizeLabel"
          />


        </div>
      @endif

    </div>
  </section>


  <script type="text/javascript" defer>
    function createOWL{{$id}}(){
      var owl = $('#{{$id}}Carousel');
      owl.trigger('destroy.owl.carousel');
      owl.owlCarousel({
        loop: {!! $loop ? 'true' : 'false' !!},
        lazyLoad: true,
        margin: {!! $margin !!},
        dots: {!! $dots ? 'true' : 'false' !!},
        responsiveClass: {!! $responsiveClass ? 'true' : 'false' !!},
        autoplay: {!! $autoplay ? 'true' : 'false' !!},
        nav: {!! $nav ? 'true' : 'false' !!},
        autoplayHoverPause: {!! $autoplayHoverPause ? 'true' : 'false' !!},
        center: {!! $center ? 'true' : 'false' !!},
        responsive: {!! $responsive !!},
        stagePadding: {!!$stagePadding!!},
        {!! !empty($navText) ? 'navText: '.$navText."," : "" !!}
      });

      $('#{{$id}} .nextBtn').click(function() {
        owl.trigger('next.owl.carousel');
      });
      $('#{{$id}} .prevBtn').click(function() {
        owl.trigger('prev.owl.carousel', [300]);
      });
      owl.trigger('refresh.owl.carousel');
    }

    document.addEventListener('DOMContentLoaded', function () {
  
      function refreshOwl(){

          createOWL{{$id}}();
      
          let sizeButton = document.querySelector('#{{$id}} .prevBtn');
          let width = sizeButton.offsetWidth;
      
          let wrapper = document.querySelector('#{{$id}} .wrapper');
          let w = (width)*2 +20;
          if(wrapper != null) {
            wrapper.style.cssText = 'grid-template-columns: '+width+'px calc(100% - '+w+'px) '+width+'px';
          }

      }

     createOWL{{$id}}();
  
      @if($nav && $navPosition=="center")
        window.addEventListener('owlRefreshed', refreshOwl())
        refreshOwl();
      @endif
    });

  
  </script>


  <style>
    @if($nav && $navPosition=="center")
    #{{$id}} .wrapper {
      display: grid;
      align-items: center;
      grid-gap: 5px;
      margin-right: -25px;
      margin-left: -15px;
    }
    @media (max-width: 768px) {
        #{{$id}} .wrapper {
            grid-template-columns: 1fr 1fr !important;
        }
        #{{$id}} .wrapper > div:nth-child(1) {
             text-align: right;
         }
        #{{$id}} .wrapper > div:nth-child(2) {
             grid-row: 1/1;
             grid-column: 1/3;
        }
    }
    @endif
    @if($dotsStyle=="dots-linear")
    #{{$id}} .dots-linear .owl-dots .owl-dot span {
           width: 30px !important;
           height: 5px !important;
           margin: 0 5px !important;
           border-radius: 0;
         }
    #{{$id}} .dots-linear .owl-dots .owl-dot.active span,
    #{{$id}} .dots-linear .owl-dots .owl-dot:hover span {
       background: var(--primary) !important;
     }
    #{{$id}} .dots-linear .owl-dots .owl-dot:focus {
       outline: 0 !important;
     }
    @endif

  </style>



@endif