
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

<div id="{{$id}}" class="item-layout item-list-layout-7 position-relative overflow-hidden {{$itemClasses}}"
    {{ $itemAnimate ? 'data-aos='.$itemAnimate : '' }}
    {{ $itemDelay ? 'data-aos-delay='.$itemDelay : '' }}
    {{ $itemDuration ? 'data-aos-duration='.$itemDuration : '' }}
    {{ $itemOffset ? 'data-aos-offset='.$itemOffset : '' }}
    {{ $itemEasing ? 'data-aos-easing='.$itemEasing  : '' }}
    {{ $itemOne ? 'data-aos-once='.$itemOne  : '' }}
    {{ $itemMirror ? 'data-aos-mirror='.$itemMirror  : '' }}>
  <x-isite::edit-link link="{{$editLink}}{{$item->id}}" :item="$item" tooltip="{{$tooltipEditLink}}"/>
  <div class="card-item {{$row}} @if($imageOpacityHover) opacity-with-hover @else opacity-without-hover @endif">
    <div class="{{$imagePosition!='1' ? 'row no-gutters' : ''}}">
        @if(method_exists ( $item, "mediaFiles" ) && $withImage )

          <div class="item-image {{$col1}} {{$imagePositionVertical}} @if($withImageOpacity) {{$imageOpacityColor}} {{$imageOpacityDirection}} @endif">
            <x-media::single-image :alt="$item->title ?? $item->name" :title="$item->title ?? $item->name" :
                                   :url="$item->url ?? null" :isMedia="true" :target="$target"
                                   :withVideoControls="$videoControls" :loopVideo="$videoLoop"
                                   :autoplayVideo="$videoAutoplay" :mutedVideo="$videoMuted"
                                   imgClasses="img-style" imgStyles="width:{{$imageWidth}}% !important; height:{{$imageHeight}};"
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
                  <div class="category {{$categoryClasses}} {{$categoryTextWeight}} {{$categoryColor}} {{$categoryMarginT}} {{$categoryMarginB}}">
                    {{$item->category->title ?? $item->category->name}}
                  </div>
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
    @if($imageAnimateOpacityHover!=="")
    #{{$id}} .card-item .item-image picture:before {
         content: "";
         z-index: 2;
         transition: all .5s ease 0s;
         border-bottom-left-radius: 0 !important;
         border-bottom-right-radius: 0 !important;

        @if($imageAnimateOpacityHover=="opacity-animate-2")
        height: calc( 50% - {{$imagePadding}}px);
        transform-origin: 100% 0;
        transform: rotateZ(90deg);
        @endif

        @if($imageAnimateOpacityHover=="opacity-animate-3")
        transition: all .6s linear 0s;
        width: 0;
        left: -100%;
        @endif

        @if($imageAnimateOpacityHover=="opacity-animate-4")
        transition: all .5s linear 0s;
        top: 100%;
        @endif

        @if($imageAnimateOpacityHover=="opacity-animate-5")
        transform: perspective(200px) rotateX(-90deg);
        transform-origin: center top 0;
        opacity: 0;
        @endif

        @if($imageAnimateOpacityHover=="opacity-animate-6")
        opacity: 0;
        transform: rotate3d(-1,1,0,100deg);
        transition: all .6s ease-in-out 0s;
        @endif
    }
    @endif
    @if($imageAnimateOpacityHover=="opacity-animate-2")
    #{{$id}} .card-item .item-image picture:after {
         content: "";
         z-index: 2;
         position:absolute;
         height: calc( 50% - {{$imagePadding}}px);
         transition: all .5s ease 0s;
         transform-origin: 0 100%;
         transform: rotateZ(90deg);
         top: auto !important;
         bottom: {{$imagePadding}}px !important;
     }
    #{{$id}} .card-item:hover .item-image picture:after {
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
         transform: rotateZ(0);
     }
    @endif
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
         @if($imageAnimateOpacityHover=="opacity-animate-2")
         transform: rotateZ(0);
         @endif

        @if($imageAnimateOpacityHover=="opacity-animate-3")
        width: calc( 100% - {{$imagePadding + $imagePadding}}px);
        @endif

        @if($imageAnimateOpacityHover=="opacity-animate-5")
        opacity: 1;
        transform: perspective(200px) rotateX(0);
        @endif

        @if($imageAnimateOpacityHover=="opacity-animate-6")
        opacity: .9;
        transform: rotate3d(0,0,0,0deg);
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
        @if($imageAnimate!='')
            z-index: 1;
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
        max-height: {{$imageMaxHeight}};
        min-height: {{$imageMinHeight}};
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
      max-height: {{$imageMaxHeight}};
      min-height: {{$imageMinHeight}};
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
        @if($titleColor=="text-custom") color: {{$titleColorCustom}}; @endif
    }
    #{{$id}} .item-summary .summary {
        font-size: {{$summaryTextSize}}px;
        letter-spacing: {{$summaryLetterSpacing}}px;
        line-height: {{$summaryLineHeight}}px;
        overflow: hidden;
        height: @if($summaryHeight) {{$summaryHeight}}px @else auto @endif;
        text-shadow:  {{$summaryShadow}};
        @if($summaryColor=="text-custom") color: {{$summaryColorCustom}}; @endif
    }
    #{{$id}} .item-category .category {
        font-size: {{$categoryTextSize}}px;
        letter-spacing: {{$categoryLetterSpacing}}px;
        text-shadow:  {{$categoryShadow}};
        @if($categoryColor=="text-custom") color: {{$categoryColorCustom}}; @endif
    }
    #{{$id}} .item-created-date .created-date {
        font-size: {{$createdDateTextSize}}px;
        letter-spacing: {{$createdDateLetterSpacing}}px;
        text-shadow:  {{$createdDateShadow}};
        @if($createdDateColor=="text-custom") color: {{$createDateColorCustom}}; @endif
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

    @if($imageAnimate=="image-animate-scale-all")
    #{{$id}} .card-item picture  {
         overflow: hidden;
         transition: all .3s ease-in;
     }
    #{{$id}} .card-item:hover .img-style {
         transform: scale(1.1);
     }
    @endif
    @if($imageAnimate=="image-animate-rotate-1")
    #{{$id}} .card-item:hover .img-style {
         transform: rotate(1deg);
     }
    @endif
    @if($imageAnimate=="image-animate-up")
    #{{$id}} .card-item   {
         margin-top: 15px;
         transition: all .3s ease-in;
     }
    #{{$id}} .card-item:hover  {
         margin-top: 5px;
     }
    @endif

    @if($contentAnimateOpacityHover!=="" && $imageOpacityHover && $withImageOpacity)

    #{{$id}} .card-item .item-content {
         z-index: 2;
         margin: {{$imagePadding}}px;
         @if($contentAnimateOpacityHover=="content-animate-1")
         opacity: 0;
         transform: translate(-50%,-50%) scale(.5);
         transition: all .35s ease;
         top: 50%;
         left: 50%;
         @endif

        @if($contentAnimateOpacityHover=="content-animate-2")
        transition: all .3s ease 0s;
        bottom: -100%;
        left: 0;
        @endif

        @if($contentAnimateOpacityHover=="content-animate-3")
        top: 45%;
        opacity: 0;
        transform: translate(10%,-30%);
        transition: all .2s ease-out 0s;
        @endif

        @if($contentAnimateOpacityHover=="content-animate-4")
        opacity: 0;
        transform: translate3d(0,-50px,0);
        transition: transform .5s ease 0s;
        @endif

        @if($contentAnimateOpacityHover=="content-animate-5")
        transform: scale(0);
        transition: all .3s ease 0s;
        @endif
    }

    #{{$id}} .card-item:hover .item-content {
        @if($contentAnimateOpacityHover=="content-animate-1")
        transform: translate(-50%,-50%) scale(1);
        opacity: 1;
        @endif

        @if($contentAnimateOpacityHover=="content-animate-2")
        bottom: 0;
        @endif

        @if($contentAnimateOpacityHover=="content-animate-3")
        opacity: 1;
        transform: translate(0,-50%);
        transition-delay: .2s;
        @endif

        @if($contentAnimateOpacityHover=="content-animate-4")
        opacity: 1;
        transform: translate3d(0,0,0);
        @endif

        @if($contentAnimateOpacityHover=="content-animate-5")
        transform: scale(1);
         @endif
    }

    @if($contentAnimateOpacityHover=="content-animate-5")
    #{{$id}} .card-item .item-content:before {
         border-bottom: 1px solid rgba(255,255,255,.5);
         border-top: 1px solid rgba(255,255,255,.5);
         transform: scale(0,1);
         transform-origin: 0 0 0;
     }
    #{{$id}} .card-item .item-content:after {
         border-left: 1px solid rgba(255,255,255,.5);
         border-right: 1px solid rgba(255,255,255,.5);
         transform: scale(1,0);
         transform-origin: 100% 0 0;
     }
    #{{$id}} .card-item .item-content:after,
    #{{$id}} .card-item .item-content:before {
         content: "";
         position: absolute;
         top: 4%;
         left: 4%;
         bottom: 4%;
         right: 4%;
         opacity: 0;
         transition: all .7s ease 0s;
         z-index: 3;
    }

    #{{$id}} .card-item:hover .item-content:after,
    #{{$id}} .card-item:hover .item-content:before {
         opacity: 1;
         transform: scale(1);
         transition-delay: .15s;
    }
    @endif
    @if($contentAnimateOpacityHover=="content-animate-6")
    #{{$id}} .card-item .item-content:before {
         border-left: 2px solid rgba(255,255,255,.5);
         border-top: 2px solid rgba(255,255,255,.5);
         top: 4%;
         left: 4%;
         transform: scale(0,1);
         transform-origin: 0 0 0;
     }
    #{{$id}} .card-item .item-content:after {
         border-bottom: 2px solid rgba(255,255,255,.5);
         border-right: 2px solid rgba(255,255,255,.5);
         bottom: 4%;
         right: 4%;
         transform: scale(1,0);
         transform-origin: 100% 0 0;
     }
    #{{$id}} .card-item .item-content:after,
    #{{$id}} .card-item .item-content:before {
         content: "";
         position: absolute;
         z-index: 3;
         width: 50px;
         height: 50px;
         opacity: 0;
         transition: all .7s ease 0s;
     }
    #{{$id}} .card-item:hover .item-content:after,
    #{{$id}} .card-item:hover .item-content:before {
         opacity: 1;
         transform: scale(1);
         transition-delay: .15s;
     }
    @endif
    @endif

    @if($contentAnimateOpacityHover!=="" && !$imageOpacityHover && $withImageOpacity)
    @if($contentAnimateOpacityHover=="content-animate-5")
    #{{$id}} .card-item .item-content:before {
         border-bottom: 1px solid rgba(255,255,255,.5);
         border-top: 1px solid rgba(255,255,255,.5);
         transform-origin: 0 0 0;
     }
    #{{$id}} .card-item .item-content:after {
         border-left: 1px solid rgba(255,255,255,.5);
         border-right: 1px solid rgba(255,255,255,.5);
         transform-origin: 100% 0 0;
     }
    #{{$id}} .card-item .item-content:after,
    #{{$id}} .card-item .item-content:before {
         content: "";
         position: absolute;
         top: 4%;
         left: 4%;
         bottom: 4%;
         right: 4%;
         z-index: 3;
     }
    @endif

    @if($contentAnimateOpacityHover=="content-animate-6")
     #{{$id}} .card-item .item-content:before {
         border-left: 1px solid rgba(255,255,255,.5);
         border-top: 1px solid rgba(255,255,255,.5);
         top: 4%;
         left: 4%;
     }
    #{{$id}} .card-item .item-content:after {
         border-bottom: 1px solid rgba(255,255,255,.5);
         border-right: 1px solid rgba(255,255,255,.5);
         bottom: 4%;
         right: 4%;
     }
    #{{$id}} .card-item .item-content:after,
    #{{$id}} .card-item .item-content:before {
         content: "";
         position: absolute;
         z-index: 3;
         width: 50px;
         height: 50px;
     }
    @endif
    @endif

</style>
</div>


