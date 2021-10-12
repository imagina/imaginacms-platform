<div class="item-layout item-list-layout-3 position-relative">
  <x-isite::edit-link link="{{$editLink}}{{$item->id}}" tooltip="{{$tooltipEditLink}}"/>
  <div class="card card-item">
    @if(method_exists ( $item, "mediaFiles" ) )
      <div class="item-image">
        <x-media::single-image :alt="$item->title ?? $item->name" :title="$item->title ?? $item->name" :
                               :url="$item->url ?? null" :isMedia="true" width="100%" :target="$target"
                               :mediaFiles="$item->mediaFiles()" :zone="$mediaImage ?? 'mainimage'"/>
      </div>
    @endif
    <div class="card-img-overlay item-content">

      <div class="{{$orderClasses["title"] ?? 'order-1'}} item-title">
        @if(isset($item->url))
          <a href="{{$item->url}}" target="{{$target}}">
            @endif
            <h3 class="title">
              {{$item->title ?? $item->name}}
            </h3>
            @if(isset($item->url))
          </a>
        @endif
      </div>
      @if($withCreatedDate && isset($item->created_at))
        <div class="{{$orderClasses["date"] ?? 'order-2'}} item-created-date">
          @if(isset($item->url))
            <a href="{{$item->url}}" target="{{$target}}">
              @endif
              <div class="created-date">{{ $item->created_at->format($formatCreatedDate) }}</div>
              @if(isset($item->url))
            </a>
          @endif
        </div>
      @endif
      @if($withCategory && isset($item->category->id))
        <div class="{{$orderClasses["categoryTitle"] ?? 'order-3'}} item-category">
          @if(isset($item->category->url))
            <a href="{{$item->category->url}}" target="{{$target}}">
              @endif
              <h5 class="category">
                {{$item->category->title ?? $item->category->name}}
              </h5>
              @if(isset($item->category->url))
            </a>
          @endif
        </div>
      @endif
      @if($withSummary && ( isset($item->summary) || isset($item->description) || isset($item->custom_html)) )
        <div class="{{$orderClasses["summary"] ?? 'order-4'}} item-summary">
          @if(isset($item->url))
            <a href="{{$item->url}}" target="{{$target}}">
              @endif
              <div class="summary"> ad
                {!! Str::limit( $item->summary ?? $item->description ??  $item->custom_html ?? '', $numberCharactersSummary) !!}
              </div>
              @if(isset($item->url))
            </a>
          @endif
        </div>
      @endif
      @if($withViewMoreButton)
        <div class="{{$orderClasses["viewMoreButton"] ?? 'order-5'}} item-view-more-button">
          @if(isset($item->url))
            <a href="{{$item->url}}" class="btn view-more-button" target="{{$target}}">
              @endif
              {{trans($viewMoreButtonLabel)}}
              @if(isset($item->url))
            </a>
          @endif
        </div>
      @endif
    </div>

  </div>
</div>