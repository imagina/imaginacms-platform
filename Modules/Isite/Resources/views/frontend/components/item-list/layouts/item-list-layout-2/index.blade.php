<div class="item-layout item-list-layout-2 position-relative">
    <x-isite::edit-link link="{{$editLink}}{{$item->id}}" tooltip="{{$tooltipEditLink}}"/>
  <div class="card card-category bg-white border-0">
    @if(isset($item->url))
      <a href="{{$item->url}}">
        @endif
        <div class="row align-items-center">
          @if(method_exists ( $item, "mediaFiles" ) )
            <div class="col">
              <div class="fondo position-relative text-center p-3">
                <x-media::single-image :alt="$item->title ?? $item->name" :title="$item->title ?? $item->name" :
                                       :url="$item->url ?? null" :isMedia="true" width="100%" :target="$target"
                                       :mediaFiles="$item->mediaFiles()" :zone="$mediaImage ?? 'mainimage'"/>

              </div>
            </div>
          @endif
          <div class="col item-title">
            @if(isset($item->url))
              <a href="{{$item->url}}" target="{{$target}}">
                @endif
                <h3 class="my-4">
                  {{$item->title ?? $item->name}}
                </h3>
                @if(isset($item->url))
              </a>
            @endif
          </div>
          @if($withCreatedDate && isset($item->created_at))
            <div class="col-12 item-created-date">
              @if(isset($item->url))
                <a href="{{$item->url}}" target="{{$target}}">
                  @endif
                  <div class="date">{{ $item->created_at->format($formatCreatedDate) }}</div>
                  @if(isset($item->url))
                </a>
              @endif
            </div>
          @endif
          @if($withCategory && isset($item->category->id))
            <div class="col item-category-title">
              @if(isset($item->category->url))
                <a href="{{$item->category->url}}" target="{{$target}}">
                  @endif
                  <h5 class="my-4">
                    {{$item->category->title ?? $item->category->name}}
                  </h5>
                  @if(isset($item->category->url))
                </a>
              @endif
            </div>
          @endif
          @if($withSummary && ( isset($item->summary) || isset($item->description)|| isset($item->custom_html)) )
            <div class="col item-summary">
              @if(isset($item->url))
                <a href="{{$item->url}}" target="{{$target}}">
                  @endif
                  <div class="my-4">
                    {!! Str::limit($item->summary ?? $item->description ??  $item->custom_html ?? '', $numberCharactersSummary)!!}
                  </div>
                  @if(isset($item->url))
                </a>
              @endif
            </div>
          @endif
          @if($withViewMoreButton)
            <div class="col-12 item-view-more-button">
              @if(isset($item->url))
                <a href="{{$item->url}}" class="btn" target="{{$target}}">
                  @endif
                  {{trans($viewMoreButtonLabel)}}
                  @if(isset($item->url))
                </a>
              @endif
            </div>
          @endif
        </div>
        @if(isset($item->url))
      </a>
    @endif
  </div>
</div>