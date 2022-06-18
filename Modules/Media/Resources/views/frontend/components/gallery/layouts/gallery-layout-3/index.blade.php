@if(count($gallery) > 0)
  <div class="gallery-layout-3">
    <main>
      @foreach($gallery as $item)
        <div class="item">
          <x-media::single-image :isMedia="true" :mediaFiles="$item" :dataFancybox="$dataFancybox"
                                 :autoplayVideo="$autoplayVideo" :loopVideo="$loopVideo" :mutedVideo="$mutedVideo"/>
        </div>
      @endforeach
    </main>
  </div>
@endif

<style>
    main {
        display: grid;
        grid-gap: 1rem;
        grid-template-columns: 200px 200px 200px;
        grid-template-rows: 150px 150px;
    }
</style>