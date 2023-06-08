@extends('layouts.master')

@section('meta')
  @include('iblog::frontend.partials.post.metas')
@stop

@section('title')
  {{ $post->title }} | @parent
@stop

@section('content')
  <div id="postLayout5" class="page blog single single-{{$category->slug}} single-{{$category->id}}">
    @include('iblog::frontend.partials.breadcrumb')
    <div class="container">
      <div class="row justify-content-center">
        {{--article--}}
        <div class="col-12 col-md-8 col-lg-8 px-md-4">
          <div class="my-1">
            <x-media::single-image imgClasses=""
                                   :mediaFiles="$post->mediaFiles()"
                                   :isMedia="true" :alt="$post->title"/>
          </div>
          <h1 class="title mt-4 h3">{{ $post->title }}</h1>
          <div class="create-date my-4">
            {{ $post->created_at->format('d \d\e M, Y')}}
          </div>
          <div class="page-body description my-4 text-justify">
            {!! $post->description !!}
          </div>
          <div class="social-share d-flex justify-content-start align-items-center my-5">
            <div class="mr-2">{{trans('iblog::common.social.share')}}:</div>
            <div class="sharethis-inline-share-buttons"></div>
          </div>
        </div>
        {{--sidebar--}}
        <div class="col-12 col-md-4 col-lg-3">
          <div class="blog-recent mb-4">
            <h4 class="mb-2">{{trans('iblog::common.layouts.titlePostRecent')}}</h4>
            <livewire:isite::items-list
              moduleName="Iblog"
              itemComponentName="isite::item-list"
              itemComponentNamespace="Modules\Isite\View\Components\ItemList"
              :configLayoutIndex="['default' => 'one',
                                                              'options' => [
                                                                  'one' => [
                                                                      'name' => 'one',
                                                                      'class' => 'col-6 col-md-12 my-2',
                                                                      'icon' => 'fa fa-align-justify',
                                                                      'status' => true],
                                                          ],
                                                          ]"
              :itemComponentAttributes="[
                                          'withViewMoreButton'=>false,
                                          'withCategory'=>false,
                                          'withSummary'=>false,
                                          'withCreatedDate'=>false,
                                          'layout'=>'item-list-layout-7',
                                          'imageAspect'=>'4/3',
                                          'imageObject'=>'cover',
                                          'imageBorderRadio'=>'0',
                                          'imageBorderStyle'=>'solid',
                                          'imageBorderWidth'=>'0',
                                          'imageBorderColor'=>'#000000',
                                          'imagePadding'=>'0',
                                          'withTitle'=>true,
                                          'titleAlign'=>'',
                                          'titleTextSize'=>'14',
                                          'titleTextWeight'=>'font-weight-bold',
                                          'titleTextTransform'=>'',
                                          'formatCreatedDate'=>'d \d\e M,Y',
                                          'summaryAlign'=>'text-left',
                                          'summaryTextSize'=>'16',
                                          'summaryTextWeight'=>'font-weight-normal',
                                          'numberCharactersSummary'=>'100',
                                          'categoryAlign'=>'text-left',
                                          'categoryTextSize'=>'18',
                                          'categoryTextWeight'=>'font-weight-normal',
                                          'createdDateAlign'=>'text-left',
                                          'createdDateTextSize'=>'11',
                                          'createdDateTextWeight'=>'font-weight-normal',
                                          'buttonAlign'=>'text-left',
                                          'buttonLayout'=>'rounded',
                                          'buttonIcon'=>'',
                                          'buttonIconLR'=>'left',
                                          'buttonColor'=>'primary',
                                          'viewMoreButtonLabel'=>'iblog::common.layouts.viewMore',
                                          'withImageOpacity'=>false,
                                          'imageOpacityColor'=>'opacity-dark',
                                          'imageOpacityDirection'=>'opacity-all',
                                          'orderClasses'=>[
                                          'photo'=>'order-0',
                                          'title'=>'order-1',
                                          'date'=>'order-4',
                                          'categoryTitle'=>'order-3',
                                          'summary'=>'order-2',
                                          'viewMoreButton'=>'order-5'
                                          ],
                                          'imagePosition'=>'2',
                                          'imagePositionVertical'=>'align-self-star',
                                          'contentPositionVertical'=>'align-self-star',
                                          'contentPadding'=>'0',
                                          'contentBorder'=>'0',
                                          'contentBorderColor'=>'#dddddd',
                                          'contentBorderRounded'=>'0',
                                          'contentMarginInsideX'=>'mx-1',
                                          'contentBorderShadows'=>'none',
                                          'contentBorderShadowsHover'=>'',
                                          'titleColor'=>'text-dark',
                                          'summaryColor'=>'text-dark',
                                          'categoryColor'=>'text-primary',
                                          'createdDateColor'=>'text-dark',
                                          'titleMarginT'=>'mt-2',
                                          'titleMarginB'=>'mb-0 mb-md-2',
                                          'summaryMarginT'=>'mt-0',
                                          'summaryMarginB'=>'mb-2',
                                          'categoryMarginT'=>'mt-0',
                                          'categoryMarginB'=>'mb-2',
                                          'categoryOrder'=>'3',
                                          'createdDateMarginT'=>'mt-0 mt-md-3',
                                          'createdDateMarginB'=>'mb-0 mb-md-2',
                                          'createdDateOrder'=>'4',
                                          'buttonMarginT'=>'mt-0',
                                          'buttonMarginB'=>'mb-0',
                                          'buttonOrder'=>'5',
                                          'titleLetterSpacing'=>'0',
                                          'summaryLetterSpacing'=>'0',
                                          'categoryLetterSpacing'=>'0',
                                          'createdDateLetterSpacing'=>'0',
                                          'titleVineta'=>'',
                                          'titleVinetaColor'=>'text-dark',
                                          'buttonSize'=>'button-normal',
                                          'buttonTextSize'=>'16',
                                          'itemBackgroundColor'=>'#ffffff',
                                          'itemBackgroundColorHover'=>'#ffffff',
                                          'summaryHeight'=>100,
                                          'numberCharactersTitle'=>50,
                                          'columnLeft'=>'col-sm-5',
                                          'columnRight'=>'col-sm-7 px-0 pr-sm-0 pl-sm-2',
                                          'titleTextSizeMobile'=>'13',
                                              ]"
              entityName="Post"
              :showTitle="false"
              :pagination="['show'=>false]"

              :params="['take'=>4,'filter' => ['category' => $category->id ?? null]]"
              :responsiveTopContent="['mobile'=>false,'desktop'=>false]"

            />
          </div>
        </div>
      </div>
    </div>
  </div>
@stop