
@switch($imagePosition)
  @case('1')
  @php $row=""; $col1=""; $col2="image-overlay item-border";  @endphp
  @break
  @case('2')
  @php $row="item-border"; $col1=$columnLeft." "; $col2=$columnRight;  @endphp
  @break
  @case('3')
  @php $row="item-border"; $col1=$columnRight." order-1 "; $col2=$columnLeft." order-0"; @endphp
  @break
@endswitch

<div id="{{$id}}" class="item-layout item-list-layout-7 position-relative overflow-hidden {{$itemMarginB}} {{$itemClasses}}">

  <x-isite::edit-link link="{{$editLink}}{{$item->id}}" :item="$item" tooltip="{{$tooltipEditLink}}"/>
  <div class="card-item {{$row}} @if($imageOpacityHover) opacity-with-hover @else opacity-without-hover @endif">
    <div class="{{$imagePosition!='1' ? 'row no-gutters' : ''}}">
        @if(method_exists ( $item, "mediaFiles" ) && $withImage )

          <div class="item-image {{$col1}} {{$imagePositionVertical}} @if($withImageOpacity) {{$imageOpacityColor}} {{$imageOpacityDirection}} @endif">
            <x-media::single-image :alt="$item->title ?? $item->name" :title="$item->title ?? $item->name" :
                                   :url="$item->url ?? null" :isMedia="true" :target="$target"
                                   :withVideoControls="$videoControls" :loopVideo="$videoLoop"
                                   :autoplayVideo="$videoAutoplay" :mutedVideo="$videoMuted"
                                   imgClasses="img-style" imgStyles="width:{{$imageWidth}}%; height:{{$imageHeight}};"
                                   :mediaFiles="$item->mediaFiles()" :zone="$mediaImage ?? 'mainimage'"/>
          </div>
        @endif

        @if($containerActive)
            <div class="{{$containerType}} image-overlay overlay-container">
                <div class="row h-100 {{$containerJustify}} {{$containerAlign}}">
                    <div class="{{$containerColumn}} style-content">
        @else
            <div class="item-content {{$col2}} {{$contentPositionVertical}}">
        @endif

          @if($withTitle)
            <div class="{{$orderClasses["title"] ?? 'order-1'}} item-title">
              @if(isset($item->url) && !empty($item->url))
                <a href="{{$item->url}}" target="{{$target}}" class="{{$titleColor}}">
              @endif
                    <{{$titleHead}} class="title d-flex {{$titleClasses}} {{empty($item->url) ? $titleColor : '' }} {{$titleAlignVertical}} {{$titleAlign}} {{$titleTextWeight}} {{$titleTextTransform}} {{$titleMarginT}} {{$titleMarginB}}">
                                  @if($titleVineta) <i class="{{$titleVineta}} {{$titleVinetaColor}} mr-2"></i>  @endif
                                  <span>{!! Str::limit( $item->title ?? $item->name ?? '', $numberCharactersTitle) !!}</span>
                    </{{$titleHead}}>
              @if(isset($item->url) && !empty($item->url))
                </a>
              @endif
            </div>
          @endif
          @if($withCreatedDate && isset($item->created_at))
            <div class="{{$orderClasses["date"] ?? 'order-2'}} item-created-date {{$createdDateAlign}}">
              @if(isset($item->url)&& !empty($item->url))
                <a href="{{$item->url}}" target="{{$target}}">
                  @endif
                  <div
                    class="created-date {{$createdDateClasses}} {{$createdDateTextWeight}} {{$createdDateColor}} {{$createdDateMarginT}} {{$createdDateMarginB}}">
                    {{ $item->created_at->format($formatCreatedDate) }}
                  </div>
                  @if(isset($item->url) && !empty($item->url))
                </a>
              @endif
            </div>
          @endif
          @if($withUser && ( isset($item->user)))
            <div class="{{$orderClasses["user"] ?? 'order-3'}} item-user {{$userAlign}}">
              @if(isset($item->url)&& !empty($item->url))
                <a href="{{$item->url}}" target="{{$target}}">
                  @endif
                  <div
                    class="user {{$userTextWeight}} {{$userColor}} {{$userMarginT}} {{$userMarginB}}">
                    Por: {{$item->user->present()->fullname()}}
                  </div>
                  @if(isset($item->url) && !empty($item->url))
                </a>
              @endif
            </div>
          @endif
          @if($withCategory && isset($item->category->id))
            <div class=" {{$orderClasses["categoryTitle"] ?? 'order-4'}} item-category {{$categoryAlign}}">
              @if(isset($item->category->url) && !empty($item->category->url))
                <a href="{{$item->category->url}}" target="{{$target}}">
                  @endif
                  <h5 class="category {{$categoryClasses}} {{$categoryTextWeight}} {{$categoryColor}} {{$categoryMarginT}} {{$categoryMarginB}}">
                    {{$item->category->title ?? $item->category->name}}
                  </h5>
                  @if(isset($item->category->url) && !empty($item->category->url))
                </a>
              @endif
            </div>
          @endif
          @if($withSummary && ( isset($item->summary) || isset($item->description) || isset($item->custom_html)) )
            <div class=" {{$orderClasses["summary"] ?? 'order-5'}} item-summary {{$summaryAlign}}">
              @if(isset($item->url) && !empty($item->url))
                <a href="{{$item->url}}" target="{{$target}}">
                  @endif

                    <div class="summary {{$summaryClasses}} {{$summaryTextWeight}} {{$summaryColor}} {{$summaryMarginT}} {{$summaryMarginB}} {{$contentMarginInsideX}}">
                        {!! $summary !!}
                    </div>
                  @if(isset($item->url) && !empty($item->url))
                </a>
              @endif
            </div>
          @endif
          @if($withViewMoreButton)
                  <div class="{{$orderClasses["viewMoreButton"] ?? 'order-5'}} item-view-more-button {{$buttonAlign}}">
              @if(isset($item->url) && !empty($item->url))
                          @if($viewMoreButtonLabel=="")
                              @php $labelExist= false; @endphp
                          @else
                              @php $labelExist= true; @endphp
                          @endif
                          <x-isite::button :style="$buttonLayout"
                                           :buttonClasses="$buttonSize.' view-more-button '.$buttonLayout.' '.$buttonMarginT.' '.$buttonMarginB.' '.$contentMarginInsideX.' '.$buttonItemClasses"
                                           :href="$item->url"
                                           :withIcon="$buttonIconLR"
                                           :iconPosition="$buttonIconLR"
                                           :iconClass="$buttonIcon"
                                           :withLabel="$labelExist"
                                           :color="$buttonColor"
                                           :label="trans($viewMoreButtonLabel)"
                                           :target="$target"
                                           :sizeLabel="$buttonTextSize"
                                           :iconColor="$buttonIconColor"
                          />
              @endif
            </div>
          @endif
              
              @foreach($extraOrderClassesFields as $key => $extraOrderClassesField )
    
                @if(isset($item->{$extraOrderClassesField}) || isset($item->options->{$extraOrderClassesField}))
                  <div class="{{$orderClasses[$extraOrderClassesField] ?? 'order-6'}} item-{{$extraOrderClassesField}}">
        
                    @if(isset($item->{$extraOrderClassesField}))
                      {{ $item->{$extraOrderClassesField} }}
                    @elseif(isset($item->options->{$extraOrderClassesField}))
                      {{ $item->options->{$extraOrderClassesField} }}
                    @endif
      
                  </div>
                @endif
              @endforeach

        @if($containerActive)
                    </div>
                </div>
            </div>
        @else
            </div>
        @endif

    </div>
  </div>

<style>
    #{{$id}}.item-layout {
        border-radius: {{$contentRadio}};
        @if(!$contentBorderShadowsHover && ($imagePosition==="1"))
        box-shadow: {{$contentBorderShadows}};
        @endif
    }
    @if($contentBorderShadowsHover && ($imagePosition==="1"))
    #{{$id}}.item-layout:hover {
        box-shadow: {{$contentBorderShadows}};
    }
    @endif
    #{{$id}} .card-item {
         background-color: {{$itemBackgroundColor}};
    }
    #{{$id}} .card-item:hover {
         background-color: {{$itemBackgroundColorHover}};
    }
    @if((!$imageOpacityHover) && $withImageOpacity && ($imageOpacityColor=='opacity-custom'))
    #{{$id}} .item-image picture {
        position: relative;
        display: block !important;
        overflow: hidden;
    }
    @endif
    @if($withImageOpacity )
    #{{$id}} .image-link {
        z-index: 1; position: relative;
    }
    #{{$id}} .item-content > div {
         z-index: 1;
    }
    @endif
    @if($imageOpacityHover && $withImageOpacity)
    @if($imagePosition=="1")
    #{{$id}} .card-item .item-content {
        opacity: 0;
    }
    #{{$id}} .card-item:hover .item-content {
        opacity: 1;
    }
    @endif
    #{{$id}} .card-item:hover .item-image picture {
        position: relative;
        display: block !important;
        overflow: hidden;
        transition: background 0.5s ease-out;
    }
    #{{$id}} .card-item:hover .item-image picture:before {
         border-radius: {{$imageRadio}};
         top: {{$imagePadding}}px;
         left: {{$imagePadding}}px;
         bottom: {{$imagePadding}}px;
         right: {{$imagePadding}}px;
         @if($imageOpacityColor=='opacity-custom')
         content: "";
         position: absolute;
         background: {{$imageOpacityCustom}};
         @endif
    }
    @endif
    #{{$id}} .item-image picture:before {
        border-radius: {{$imageRadio}};
        top: {{$imagePadding}}px;
        left: {{$imagePadding}}px;
        bottom: {{$imagePadding}}px;
        right: {{$imagePadding}}px;
        @if((!$imageOpacityHover) && $withImageOpacity && ($imageOpacityColor=='opacity-custom'))
            content: "";
            position: absolute;
            background: {{$imageOpacityCustom}};
        @endif
    }

    #{{$id}} .item-image picture {
        display: block !important;
        padding: {{$imagePicturePadding}}px;
        text-align: {{$imageAlign}};
    }
    #{{$id}} .img-style  {
        border-radius: {{$imageRadio}};
        border-style: {{$imageBorderStyle}};
        border-width: {{$imageBorderWidth}}px;
        border-color: {{$imageBorderColor}};
        aspect-ratio: {{$imageAspect}};
        object-fit: {{$imageObject}};
        padding: {{$imagePadding}}px;
        display: inline-flex;
        box-shadow:  {{$imageShadow}};
        transition: all 0.25s ease-out;
    }
    #{{$id}} .cover-img {
      border-radius: {{$imageRadio}};
      border-style: {{$imageBorderStyle}};
      border-width: {{$imageBorderWidth}}px;
      border-color: {{$imageBorderColor}};
      aspect-ratio: {{$imageAspect}};
      padding: {{$imagePadding}}px;
      box-shadow:  {{$imageShadow}};
      height: {{$imageHeight}} !important;
      z-index: 1;
      position: relative;
    }
    @if($contentBorderShadows=='none')
        #{{$id}} .item-border {
            @if($imagePosition==2 || $imagePosition==3)
            padding-left: {{$contentPaddingL}}px;
            padding-right: {{$contentPaddingR}}px;
            padding-top: {{$contentPaddingT}}px;
            padding-bottom: {{$contentPaddingB}}px;
            @else
            padding-left: {{$contentPaddingL + $imagePadding}}px;
            padding-right: {{$contentPaddingR + $imagePadding}}px;
            padding-top: {{$contentPaddingT + $imagePadding}}px;
            padding-bottom: {{$contentPaddingB + $imagePadding}}px;
            @endif
            border-width: {{$contentBorder}}px;
            border-style: solid;
            border-color: {{$contentBorderColor}};
            border-radius: {{$contentRadio}};
        }
    @else
        #{{$id}} .item-border {
            @if($imagePosition==2 || $imagePosition==3)
            padding-left: {{$contentPaddingL}}px;
            padding-right: {{$contentPaddingR}}px;
            padding-top: {{$contentPaddingT}}px;
            padding-bottom: {{$contentPaddingB}}px;
            @else
            padding-left: {{$contentPaddingL + $imagePadding}}px;
            padding-right: {{$contentPaddingR + $imagePadding}}px;
            padding-top: {{$contentPaddingT + $imagePadding}}px;
            padding-bottom: {{$contentPaddingB + $imagePadding}}px;
            @endif
            border-width: {{$contentBorder}}px;
            border-style: solid;
            border-color: {{$contentBorderColor}};
            border-radius: {{$contentRadio}};
            @if(!$contentBorderShadowsHover && ($imagePosition!=="1"))
                box-shadow: {{$contentBorderShadows}};
            @endif
            @if(($contentBorderShadows!=='none' || $contentBorderShadows!=='') && ($imagePosition!=="1"))
                margin: 5px;
            @endif
        }
        @if($contentBorderShadowsHover && ($imagePosition!=="1"))
        #{{$id}} .item-border:hover {
            box-shadow: {{$contentBorderShadows}};
        }
        @endif
    @endif

    #{{$id}} .item-title .title {
        font-size: {{$titleTextSize}}px;
        letter-spacing: {{$titleLetterSpacing}}px;
        overflow: hidden;
        height: @if($titleHeight) {{$titleHeight}}px @else auto @endif;
        text-shadow:  {{$titleShadow}};
    }
    #{{$id}} .item-summary .summary {
        font-size: {{$summaryTextSize}}px;
        letter-spacing: {{$summaryLetterSpacing}}px;
        line-height: {{$summaryLineHeight}}px;
        overflow: hidden;
        height: @if($summaryHeight) {{$summaryHeight}}px @else auto @endif;
        text-shadow:  {{$summaryShadow}};
    }
    #{{$id}} .item-category .category {
        font-size: {{$categoryTextSize}}px;
        letter-spacing: {{$categoryLetterSpacing}}px;
        text-shadow:  {{$categoryShadow}};
    }
    #{{$id}} .item-created-date .created-date {
        font-size: {{$createdDateTextSize}}px;
        letter-spacing: {{$createdDateLetterSpacing}}px;
        text-shadow:  {{$createdDateShadow}};
    }
    #{{$id}} .item-view-more-button .view-more-button {
         text-shadow:  {{$buttonShadow}};
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
    @if($imagePosition!=='1')
    #{{$id}} .item-content {
        padding-left: {{$contentPaddingLeft}}px;
        padding-right: {{$contentPaddingRight}}px;
    }
    @endif
    #{{$id}} .style-content {
         background: {{$contentBackground}};
         padding-left: {{$contentPaddingL}}px;
         padding-right: {{$contentPaddingR}}px;
         padding-top: {{$contentPaddingT}}px;
         padding-bottom: {{$contentPaddingB}}px;
    }
    @media (max-width: 991.98px) {
        #{{$id}} .item-title .title {
        font-size: {{$titleTextSizeMobile}}px;
        }
    }
    @if(!is_null($imageAspectMobile))
    @media (max-width: 767.98px) {
        #{{$id}} .img-style, #{{$id}} .cover-img{
            aspect-ratio: {{$imageAspectMobile}};
        }
    }
    @endif
    #{{$id}} .overlay-container { z-index: 1;}

    @if($buttonLayout=="button-custom")
    #{{$id}} .button-custom {
        color: {{$buttonConfig["color"]}};
        border: {{$buttonConfig["border"] ?? '0'}};
        background: {{$buttonConfig["background"]}};
        border-radius: {{$buttonConfig["borderRadius"]}};
        box-shadow: {{$buttonConfig["boxShadow"]}};
        transition: {{$buttonConfig["transition"]}};
    }
    #{{$id}} .button-custom:hover {
        color: {{$buttonConfig["colorHover"]}};
        border: {{$buttonConfig["borderHover"] ?? '0' }};
        background: {{$buttonConfig["backgroundHover"]}};
        box-shadow: {{$buttonConfig["boxShadowHover"]}};
    }
    @endif

    @if( $item->mediaFiles()->{$mediaImage}->isVideo)
        #{{$id}} .item-content > div {
            z-index: 2;
        }
        @if($withImageOpacity && ($imageOpacityColor=='opacity-custom'))
            @if(!$imageOpacityHover)
            #{{$id}}  .item-image {
                position:relative;
            }
            #{{$id}}  .item-image:before {
                border-radius: {{$imageRadio}};
                top: {{$imagePadding}}px;
                left: {{$imagePadding}}px;
                bottom: {{$imagePadding}}px;
                right: {{$imagePadding}}px;
                position: absolute;
                background: {{$imageOpacityCustom}};
                content: '';
                 z-index: 2;
            }
            @else
                #{{$id}} .card-item:hover .item-image {
                    position:relative
                }
                #{{$id}} .card-item:hover .item-image:before {
                     border-radius: {{$imageRadio}};
                     top: {{$imagePadding}}px;
                     left: {{$imagePadding}}px;
                     bottom: {{$imagePadding}}px;
                     right: {{$imagePadding}}px;
                     position: absolute;
                     background: {{$imageOpacityCustom}};
                     content: '';
                     z-index: 2;
                }
            @endif
        @endif

    @endif


</style>
</div>


