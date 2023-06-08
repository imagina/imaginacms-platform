<div class="pins">
  <div class="card-pin {{$item->featured ? 'featured' : ''}}">

    <figure class="figure" data-toggle="modal" data-target="#modalPin{{$item->id}}">
      @if($item->featured )
        <a class="link-star">
          <i class="fa fa-star text-white"></i>
        </a>
      @endif
      <x-media::single-image :alt="$item->title ?? $item->name"
                             :title="$item->title ?? $item->name"
                             :url="!$embedded ? $item->url ?? null : null" :isMedia="true"
                             imgClasses=""
                             :mediaFiles="$item->mediaFiles()"/>
      <a class="link-like">
        <i class="fa fa-heart"></i>
      </a>

    </figure>

    <div class="card-body p-0">
      @if(!$embedded)
        <a href="{{$item->url ?? ''}}">
          @endif
          <h5 class="card-title" type="button">
            {{$item->title}}
            <br>
            @if(isset($item->fields->where('name','name')->first()->value))
              {{$item->fields->where('name','name')->first()->value}}
            @endif
          </h5>
          @if(!$embedded)
        </a>
      @endif
      <div id="extraInfo" class="d-inline-block">
        @if(isset($item->city->name))
          <span class="badge info-badge">
          {{--Ciudad--}}
            <i class="fa fa-map-marker"></i>
            {{$item->city->name}}
        </span>
        @endif
        @if(isset($item->locality->name))
          <span class="badge info-badge">
          {{--Localidad--}}
            <i class="fa fa-map-marker"></i>
            {{$item->locality->name}}
        </span>
        @endif
        @if(isset($item->neighborhood->name))
          <span class="badge info-badge">
          {{--Barrio--}}
            <i class="fa fa-thumb-tack"></i>
            {{$item->neighborhood->name}}
        </span>
        @endif
        @if(isset(collect($item->fields)->where('name','age')->first()->value))
          <span class="badge info-badge">
          {{--21 años--}}
            {{collect($item->fields)->where('name','age')->first()->value}} años
        </span>
        @endif

        @if(!empty($item->defaultPrice))
          <span class="badge info-badge">${{formatMoney($item->defaultPrice)}}</span>
        @endif

        <span class="badge info-badge">{{$item->country->name}}</span>
        @if($item->status == 3)
          <span class="badge info-badge certified" title="{{trans("iad::status.checked")}}"></span>
        @endif
        @php($videos = $item->mediaFiles()->videos)
        @php($gallery = $item->mediaFiles()->gallery)
        @if(count($videos)>0)
          <span class="badge info-badge videos">
            <i class="fa fa-play-circle-o" aria-hidden="true"></i>
            {{count($videos)}}</span>
        @endif
        @if(count($gallery)>0)
          <span class="badge info-badge photos">
            <i class="fa fa-camera" aria-hidden="true"></i>
            {{count($gallery)}}</span>
        @endif
        @if($item->checked)
          <span class="badge info-badge videos">
          <a class="link-verified" data-toggle="tooltip" title="{{trans('iad::ads.verifiedAd')}}">
            <i class="fa fa-check-square text-white"></i>
          </a>
          </span>
        @endif
      </div>
    </div>
  </div>
</div>