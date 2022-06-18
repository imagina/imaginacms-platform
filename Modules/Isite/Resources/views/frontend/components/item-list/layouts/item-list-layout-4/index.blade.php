<div class="item-layout item-list-layout-4 position-relative">
  <x-isite::edit-link link="{{$editLink}}{{$item->id}}" tooltip="{{$tooltipEditLink}}"/>
  <div class="card-item m-1">
    <div class="row align-items-center">
      @if(method_exists ( $item, "mediaFiles" ) )
        <div class="col-lg-6 item-image">

          <x-media::single-image :alt="$item->title ?? $item->name" :title="$item->title ?? $item->name" :
                                 :url="$item->url ?? null" :isMedia="true" width="100%" :target="$target"
                                 :mediaFiles="$item->mediaFiles()" :zone="$mediaImage ?? 'mainimage'"/>

        </div>
      @endif
      <div class="col-lg-6 item-content">

        <div class="{{$orderClasses["title"] ?? 'order-1'}} item-title">
          @if(isset($item->url) && !empty($item->url))
            <a href="{{$item->url}}" target="{{$target}}">
              @endif
              <h3 class="title">
                {{$item->title ?? $item->name}}
              </h3>
              @if(isset($item->url) && !empty($item->url))
            </a>
          @endif
        </div>
        @if($withCreatedDate && isset($item->created_at))
          <div class="{{$orderClasses["date"] ?? 'order-2'}} item-created-date">
            @if(isset($item->url) && !empty($item->url))
              <a href="{{$item->url}}" target="{{$target}}">
                @endif
                <div class="created-date">{{ $item->created_at->format($formatCreatedDate) }}</div>
                @if(isset($item->url) && !empty($item->url))
              </a>
            @endif
          </div>
        @endif
        @if($withUser && ( isset($item->user)))
          <div class="{{$orderClasses["user"] ?? 'order-3'}} item-user">
            @if(isset($item->url) && !empty($item->url))
              <a href="{{$item->url}}" target="{{$target}}">
                @endif
                <div class="created-date">Por: {{$item->user->present()->fullname()}}</div>
                @if(isset($item->url) && !empty($item->url))
              </a>
            @endif
          </div>
        @endif
        @if($withCategory && isset($item->category->id))
          <div class="{{$orderClasses["categoryTitle"] ?? 'order-4'}} item-category">
            @if(isset($item->category->url) && !empty($item->category->url))
              <a href="{{$item->category->url}}" target="{{$target}}">
                @endif
                <h5 class="category">
                  {{$item->category->title ?? $item->category->name}}
                </h5>
                @if(isset($item->category->url) && !empty($item->category->url))
              </a>
            @endif
          </div>
        @endif
        @if($withSummary && ( isset($item->summary) || isset($item->description)|| isset($item->custom_html)) )
          <div class="{{$orderClasses["summary"] ?? 'order-5'}} item-summary">
            @if(isset($item->url) && !empty($item->url))
              <a href="{{$item->url}}" target="{{$target}}">
                @endif
                <div class="summary">
                  {!! Str::limit( $item->summary ?? $item->description ??  $item->custom_html ?? '', $numberCharactersSummary) !!}
                </div>
                @if(isset($item->url) && !empty($item->url))
              </a>
            @endif
          </div>
        @endif
        @if($withSummary && ( isset($item->description)|| isset($item->custom_html)) )
          <div class="{{$orderClasses["description"] ?? 'order-6'}} item-description">
            @if(isset($item->url) && !empty($item->url))
              <a href="{{$item->url}}" target="{{$target}}">
                @endif
                <div class="description">
                  {!!$item->description ??  $item->custom_html ?? ''!!}
                </div>
                @if(isset($item->url) && !empty($item->url))
              </a>
            @endif
          </div>
        @endif
        @if($withViewMoreButton)
          <div class="{{$orderClasses["viewMoreButton"] ?? 'order-7'}} item-view-more-button">
            @if(isset($item->url) && !empty($item->url))
              <a href="{{$item->url}}" class="btn view-more-button" target="{{$target}}">
                @endif
                {{trans($viewMoreButtonLabel)}}
                @if(isset($item->url) && !empty($item->url))
              </a>
            @endif
          </div>
        @endif

      </div>
    </div>
  </div>
</div>