@if(count($gallery) > 0)
  <div id="galleryWithHorizontalThumbs">
    <div class="row">
      <div class="col-4">
        <div id="{{$id}}Carousel" class="owl-carousel owl-image-mini owl-image-mini{{$id}} owl-theme">
          @foreach($gallery as $key=>$item)
            <div class="item">
              <x-media::single-image :isMedia="true" :mediaFiles="$item" :dataFancybox="$dataFancybox"
                                     :data-slide-to="$key"
                                     :dataTarget="'#'.$id.'PrimaryCarousel'" :autoplayVideo="$autoplayVideo"
                                     :loopVideo="$loopVideo" :mutedVideo="$mutedVideo"/>
            </div>
            <br>
          @endforeach
        </div>
        @include("media::frontend.components.gallery.script")
      </div>
      <div class="col-8">
        <div id="{{$id}}PrimaryCarousel" class="carousel slide" data-ride="carousel">
          <a class="carousel-control-prev" href="#{{$id}}PrimaryCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#{{$id}}PrimaryCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
          <div class="carousel-inner">
            @foreach($gallery as $key=>$item)
              <div class="carousel-item @if($key == 0) active @endif">
                <x-media::single-image :isMedia="true" :mediaFiles="$item" :dataFancybox="$dataFancybox"
                                       :autoplayVideo="$autoplayVideo" :loopVideo="$loopVideo"
                                       :mutedVideo="$mutedVideo"/>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
@endif

@include('media::frontend.components.gallery.partials.style')