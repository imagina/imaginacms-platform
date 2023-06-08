<div class="card-pin {{$item->featured ? 'featured' : ''}}">
  @isset($item->url)
    <a href="{{$item->url}}">
      @endisset
      <x-media::single-image :alt="$item->title ?? $item->name"
                             :title="$item->title ?? $item->name"
                             :url="!$embedded ? $item->url ?? null : null" :isMedia="true"
                             imgClasses=""
                             :mediaFiles="$item->mediaFiles()"/>
      @isset($item->url)
    </a>
  @endisset

  <div class="card-title d-flex justify-content-center py-3 px-4">
    @if(!empty($item->defaultPrice))
      <p class="item text-muted">
      <div class="d-inline-block price">
        ${{isiteFormatMoney($item->defaultPrice)}}
      </div>
      <span class="register"></span>COP
      </p>
    @endif
  </div>

  <div class="card-body text-center">
    @isset($item->url)
      <a href="{{$item->url}}" class="text-decoration-none">
        @endisset
        <h3 class="text-muted text-justify-center"> {{$item->title}}</h3>
        @isset($item->url)
      </a>
      @endisset
      </br>

      @if(isset($item->city->name))
        <h3 class="text-center"><i class="fa fa-map-marker"></i>{{$item->city->name}}, {{$item->province->name ?? ""}}</h3>
      @endif
  </div>
  <div class="card-footer">
    <div class="col-auto text-center">
      @isset($item->url)
        <a href="{{$item->url}}" class="text-decoration-none">
          @endisset

          @if(!empty($item->options->squareMeter))
            <i class="fa fa-square-o"> {!!$item->options->squareMeter!!} m²</i>
          @endif

          @if(!empty($item->options->bedrooms))
            <i class="fa fa-bed"> {!!$item->options->bedrooms!!}</i>
          @endif

          @if(!empty($item->options->toilets))
            <i class="fa fa-shower"> {!!$item->options->toilets!!}</i>
          @endif

          @if(!empty($item->options->parking))
            <i class="fa fa-car"> {!!$item->options->parking!!}</i>
          @endif
          @isset($item->url)
        </a>
      @endisset
    </div>
  </div>
</div>
