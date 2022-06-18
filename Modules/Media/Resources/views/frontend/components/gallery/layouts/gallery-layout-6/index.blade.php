<div class="gallery-layout-6">
  <div class="row">
    <div class="items-gallery">
      @if(count($gallery) > 0)
        @foreach($gallery as $item)
          <div class="item">
            <x-media::single-image :isMedia="true" :mediaFiles="$item" :dataFancybox="$dataFancybox"
                                   :autoplayVideo="$autoplayVideo" :loopVideo="$loopVideo" :mutedVideo="$mutedVideo"/>
          </div>
        @endforeach
      @endif
    </div>
  </div>
</div>

<style>
    .items-gallery {
        display: grid;
        grid-template-columns: repeat({{$columnMasonry}}, 1fr);
        grid-gap: {{$marginItems}};
    }
    picture img {
        width: 100%;
        height: 100%;
        transition: width 1s, height 1s, transform 1s;
        -moz-transition: width 1s, height 1s, -moz-transform 1s;
        -webkit-transition: width 1s, height 1s, -webkit-transform 1s;
        -o-transition: width 1s, height 1s, -o-transform 1s;
    }
    picture img:hover {
        transform: scale(1.2);
        -moz-transform: scale(1.2); /* Firefox */
        -webkit-transform: scale(1.2); /* Chrome - Safari */
        -o-transform: scale(1.2); /* Opera */
    }
</style>
