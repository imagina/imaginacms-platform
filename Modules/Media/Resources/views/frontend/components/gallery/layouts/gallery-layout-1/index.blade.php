@if(count($gallery) > 0)
  <div id="{{$id}}Carousel" class="owl-carousel owl-theme">
    @foreach($gallery as $key=>$item)
      <div class="item">
        <x-media::single-image :isMedia="true" :mediaFiles="$item" :dataFancybox="$dataFancybox"
                               :autoplayVideo="$autoplayVideo" :loopVideo="$loopVideo" :mutedVideo="$mutedVideo"/>
      </div>
    @endforeach
  </div>
  @include("media::frontend.components.gallery.script")
@endif
