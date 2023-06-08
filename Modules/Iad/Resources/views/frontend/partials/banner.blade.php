<div class="banner-top">

  @if(isset($carouselImages) && !empty($carouselImages))

    @include('iad::frontend.partials.carousel-index-image',[
          "gallery" => $carouselImages])

  @endif

  {{-- Breadcrumb --}}
  @include('iad::frontend.partials.breadcrumb')

</div>