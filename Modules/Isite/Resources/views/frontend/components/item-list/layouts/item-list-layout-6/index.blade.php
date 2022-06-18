<div id="{{$id}}" class="item-layout item-list-layout-6 position-relative {{$itemMarginB}}">
  <x-isite::edit-link link="{{$editLink}}{{$item->id}}" tooltip="{{$tooltipEditLink}}"/>
  <div class="card-item">
    <div class="row align-items-center">

      @if(isset($item->type) && $item->type=="video")
        <div class="col-12 {{$orderClasses["photo"] ?? 'order-0'}} item-video">
          <iframe
            width="100%"
            class="embed-responsive-item"
            frameborder="0"
            allowfullscreen
            src="{{$item->url}}">
          </iframe>
        </div>

      @else

        @if(method_exists ( $item, "mediaFiles" ) && $withImage )
          <div
            class="col-12 {{$orderClasses["photo"] ?? 'order-0'}} item-image @if($withImageOpacity) {{$imageOpacityColor}} {{$imageOpacityDirection}} @endif">
            <x-media::single-image :alt="$item->title ?? $item->name" :title="$item->title ?? $item->name" :
                                   :url="$item->url ?? null" :isMedia="true"  imgClasses="img-style"
                                   :target="$target" :mediaFiles="$item->mediaFiles()" imgStyles="width: {{$imageWidth}}%;"
                                   :zone="$mediaImage ?? 'mainimage'"/>

          </div>
        @endif

      @endif
      @if($withTitle)
      <div class="col-12 {{$orderClasses["title"] ?? 'order-1'}} item-title ">
          @if(isset($item->url) && !empty($item->url))
          <a href="{{$item->url}}" target="{{$target}}" class="{{$titleColor}}">
              @endif

            <h3 class="title d-flex {{$titleAlignVertical}} {{$titleAlign}} {{$titleTextWeight}} {{$titleTextTransform}}  {{$titleMarginT}} {{$titleMarginB}} {{$contentMarginInsideX}}" style="height: @if($titleHeight) {{$titleHeight}}px @else auto @endif;">
                @if($titleVineta) <i class="{{$titleVineta}} {{$titleVinetaColor}} mr-2"></i>  @endif
                <span> {!! Str::limit( $item->title ?? $item->name ?? '', $numberCharactersTitle) !!}  </span>
              </h3>
              @if(isset($item->url) && !empty($item->url))
            </a>
          @endif
        </div>
      @endif
      @if($withCreatedDate && isset($item->created_at))
        <div class="col-12 {{$orderClasses["date"] ?? 'order-2'}} item-created-date {{$createdDateAlign}}">
          @if(isset($item->url)&& !empty($item->url))
            <a href="{{$item->url}}" target="{{$target}}">
              @endif
              <div
                class="created-date {{$createdDateTextWeight}} {{$createdDateColor}} {{$createdDateMarginT}} {{$createdDateMarginB}} {{$contentMarginInsideX}}">
                {{ $item->created_at->format($formatCreatedDate) }}
              </div>
              @if(isset($item->url) && !empty($item->url))
            </a>
          @endif
        </div>
      @endif
      @if($withUser && ( isset($item->user)))
        <div class="col-12 {{$orderClasses["user"] ?? 'order-3'}} item-user {{$userAlign}}">
          @if(isset($item->url)&& !empty($item->url))
            <a href="{{$item->url}}" target="{{$target}}">
              @endif
              <div
                class="user {{$userTextWeight}} {{$userColor}} {{$userMarginT}} {{$userMarginB}} {{$contentMarginInsideX}}">
                Por: {{$item->user->present()->fullname()}}
              </div>
              @if(isset($item->url) && !empty($item->url))
            </a>
          @endif
        </div>
      @endif
      @if($withCategory && isset($item->category->id))
        <div class="col-12 {{$orderClasses["categoryTitle"] ?? 'order-4'}} item-category {{$categoryAlign}}">
          @if(isset($item->category->url) && !empty($item->category->url))
            <a href="{{$item->category->url}}" target="{{$target}}">
              @endif
              <h5
                class="category {{$categoryTextWeight}} {{$categoryColor}} {{$categoryMarginT}} {{$categoryMarginB}} {{$contentMarginInsideX}}">
                {{$item->category->title ?? $item->category->name}}
              </h5>
              @if(isset($item->category->url) && !empty($item->category->url))
            </a>
          @endif
        </div>
      @endif
      @if($withSummary && ( isset($item->summary) || isset($item->description) || isset($item->custom_html)) )
        <div class="col-12 {{$orderClasses["summary"] ?? 'order-5'}} item-summary {{$summaryAlign}}">
          @if(isset($item->url) && !empty($item->url))
            <a href="{{$item->url}}" target="{{$target}}">
              @endif
              <div
                class="summary {{$summaryTextWeight}} {{$summaryColor}} {{$summaryMarginT}} {{$summaryMarginB}} {{$contentMarginInsideX}}" style="height: @if($summaryHeight) {{$summaryHeight}}px @else auto @endif;">
                {!! Str::limit( $item->summary ?? $item->description ?? $item->custom_html ?? '', $numberCharactersSummary) !!}
              </div>
              @if(isset($item->url) && !empty($item->url))
            </a>
          @endif
        </div>
      @endif
      @if($withViewMoreButton)
        <div class="col-12 {{$orderClasses["viewMoreButton"] ?? 'order-6'}} item-view-more-button {{$buttonAlign}}">
          @if(isset($item->url) && !empty($item->url))

                @if($viewMoreButtonLabel=="")
                    @php $labelExist= false; @endphp
                @else
                    @php $labelExist= true; @endphp
                @endif
            <x-isite::button :style="$buttonLayout"
                             :buttonClasses="$buttonSize.' view-more-button '.$buttonLayout.' '.$buttonMarginT.' '.$buttonMarginB.' '.$contentMarginInsideX"
                             :href="$item->url"
                             :withIcon="$buttonIconLR"
                             :iconPosition="$buttonIconLR"
                             :iconClass="$buttonIcon"
                             :withLabel="$labelExist"
                             :color="$buttonColor"
                             :label="trans($viewMoreButtonLabel)"
                             :target="$target"
                             :iconColor="$buttonIconColor"
                             :sizeLabel="$buttonTextSize"
            />
          @endif
        </div>
      @endif
    </div>

  </div>

<style>
    #{{$id}} .item-image picture:before {
        border-radius: {{$imageRadio}};
        top: {{$imagePadding}}px;
        left: {{$imagePadding}}px;
        bottom: {{$imagePadding}}px;
        right: {{$imagePadding}}px;
    }

   
    #{{$id}} .item-image picture {
        display: block !important;
        padding: {{$imagePicturePadding}}px;
        text-align: {{$imageAlign}};
    }
    
    #{{$id}} .img-style {
       border-radius: {{$imageRadio}};
       border-style: {{$imageBorderStyle}};
       border-width: {{$imageBorderWidth}}px;
       border-color: {{$imageBorderColor}};
       aspect-ratio: {{$imageAspect}};
       object-fit: {{$imageObject}};
       padding: {{$imagePadding}}px;
     }
 

    #{{$id}} .card-item {
        background-color: {{$itemBackgroundColor}};
        padding: {{$contentPadding}}px;
        border-width: {{$contentBorder}}px;
        border-style: solid;
        border-color: {{$contentBorderColor}};
        border-radius: {{$contentRadio}};
        @if(!$contentBorderShadowsHover)
        box-shadow: {{$contentBorderShadows}};
        @endif
        @if($contentBorderShadows)
             margin: 10px 0;
        @endif
    }
    #{{$id}} .card-item:hover {
        background-color: {{$itemBackgroundColorHover}};
        @if($contentBorderShadowsHover)
        box-shadow: {{$contentBorderShadows}};
        @endif
    }
    #{{$id}} .item-title .title {
        font-size: {{$titleTextSize}}px;
        letter-spacing: {{$titleLetterSpacing}}px;
         overflow: hidden;
    }
    #{{$id}} .item-summary .summary {
        font-size: {{$summaryTextSize}}px;
        letter-spacing: {{$summaryLetterSpacing}}px;
        line-height: {{$summaryLineHeight}}px;
        overflow: hidden;
    }
    #{{$id}} .item-category .category {
        font-size: {{$categoryTextSize}}px;
        letter-spacing: {{$categoryLetterSpacing}}px;
    }
    #{{$id}} .item-created-date .created-date {
        font-size: {{$createdDateTextSize}}px;
        letter-spacing: {{$createdDateLetterSpacing}}px;
    }
    #{{$id}} .item-title a:hover {
         text-decoration: {{$titleTextDecoration}};
     }
    #{{$id}} .item-summary a:hover {
         text-decoration: {{$summaryTextDecoration}};
     }
    #{{$id}} .item-category a:hover {
         text-decoration: {{$categoryTextDecoration}};
     }
    #{{$id}} .item-created-date a:hover {
         text-decoration: {{$createdDateTextDecoration}};
     }
</style>
</div>





