@extends('layouts.master')

@section('meta')
  @include('iblog::frontend.partials.post.metas')
@stop

@section('title')
  {{ $post->title }} | @parent
@stop

@section('content')
  <div id="postLayoutDefault" class="page blog single single-{{$category->slug}} single-{{$category->id}}">
    @include('iblog::frontend.partials.breadcrumb')
    <div class="container">
      {{-- article --}}
      <div class="row">
        <div class="col-12 col-md-8 mb-3">
          <x-media::single-image imgClasses=""
                                 :mediaFiles="$post->mediaFiles()"
                                 :isMedia="true" :alt="$post->title"/>
          <div class="mx-1 mx-md-3 mx-lg-4 mt-3">
            <span class="title mt-3 mb-2">{{ $post->created_at->format('d/m/Y')}}</span>
          </div>
          <div class="mx-1 mx-md-3 mx-lg-4">
            <h1 class="title h2">{{ $post->title }}</h1>
            <div class="page-body description mb-4 text-justify">
              {!! $post->description !!}
            </div>
            <div class="social-share d-flex justify-content-end align-items-center">
              <div class="mr-2">{{trans('iblog::common.social.share')}}:</div>
              <div class="sharethis-inline-share-buttons"></div>
              <style>
                #st-1 { z-index: 8; }
              </style>
            </div>
          </div>
        </div>
        {{-- Sidebar --}}
        <div class="col-12 col-md-4 pl-lg-5">
          <div class="categories-blog">
              <livewire:isite::filters :filters="['categories' => [
                                                                'title' => 'iblog::category.plural',
                                                                'name' => 'categories',
                                                                'typeTitle' => 'titleOfTheConfig',
                                                                'status' => true,
                                                                'isExpanded' => true,
                                                                'type' => 'tree',
                                                                'repository' => 'Modules\Iblog\Repositories\CategoryRepository',
                                                                'entityClass' => 'Modules\Iblog\Entities\Category',
                                                                'params' => ['filter' => ['internal' => false]],
                                                                'emitTo' => 'itemsListGetData',
                                                                'repoAction' => null,
                                                                'repoAttribute' => null,
                                                                'listener' => null,
                                                                'layout' => 'default',
                                                                'classes' => 'col-12'
                                                            ]]"/>
            </div>
          <div class="recent-blog my-3">
              <h4 class="mt-1 mb-3">{{trans('iblog::common.layouts.titlePostRecent')}}</h4>
              <livewire:isite::items-list
                moduleName="Iblog"
                itemComponentName="isite::item-list"
                itemComponentNamespace="Modules\Isite\View\Components\ItemList"
                :configLayoutIndex="['default' => 'one',
                                      'options' => [
                                          'one' => [
                                              'name' => 'one',
                                              'class' => 'col-12 my-2',
                                              'icon' => 'fa fa-align-justify',
                                              'status' => true],
                                        ],
                                    ]"
                :itemComponentAttributes="[
                                        'withViewMoreButton'=>false,
                                        'withCategory'=>false,
                                        'withSummary'=>false,
                                        'withCreatedDate'=>true,
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
                                        'formatCreatedDate'=>'d.m.Y',
                                        'summaryAlign'=>'text-left',
                                        'summaryTextSize'=>'16',
                                        'summaryTextWeight'=>'font-weight-normal',
                                        'numberCharactersSummary'=>'150',
                                        'createdDateAlign'=>'text-left',
                                        'createdDateTextSize'=>'11',
                                        'createdDateTextWeight'=>'font-weight-normal',
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
                                        'contentMarginInsideX'=>'mx-0',
                                        'contentBorderShadows'=>'none',
                                        'contentBorderShadowsHover'=>'',
                                        'titleColor'=>'text-dark',
                                        'summaryColor'=>'text-dark',
                                        'createdDateColor'=>'text-dark',
                                        'titleMarginT'=>'mt-2 mt-lg-0',
                                        'titleMarginB'=>'mb-1 mb-lg-0',
                                        'summaryMarginT'=>'mt-0',
                                        'summaryMarginB'=>'mb-2',
                                        'createdDateMarginT'=>'mt-0 mt-md-3',
                                        'createdDateMarginB'=>'mb-0 mb-md-2',
                                        'createdDateOrder'=>'4',
                                        'buttonOrder'=>'5',
                                        'titleLetterSpacing'=>'0',
                                        'summaryLetterSpacing'=>'0',
                                        'createdDateLetterSpacing'=>'0',
                                        'titleVineta'=>'',
                                        'titleVinetaColor'=>'text-dark',
                                        'buttonSize'=>'button-normal',
                                        'buttonTextSize'=>'16',
                                        'itemBackgroundColor'=>'#ffffff',
                                        'itemBackgroundColorHover'=>'#ffffff',
                                        'titleHeight'=>51,
                                        'columnLeft'=>'col-lg-5',
                                        'columnRight'=>'col-lg-7',
                                        'titleTextSizeMobile'=>'18',
                                       ]"
                entityName="Post"
                :showTitle="false"
                :pagination="['show'=>false]"

                :params="['take'=>5,'filter' => ['category' => $category->id ?? null]]"
                :responsiveTopContent="['mobile'=>false,'desktop'=>false]"
              />
            </div>
        </div>
        {{-- Carousel --}}
        <div class="col-12 mb-4">
            <x-isite::carousel.owl-carousel
            id="Articles"
            :title="trans('iblog::common.layouts.titleRelatedPosts')"
            owlTitleSize="18"
            owlTitleMarginT="mt-5"
            owlTitleMarginB="mb-3"
            owlTextAlign="text-center"
            owlTitleWeight="font-weight-bold"
            repository="Modules\Iblog\Repositories\PostRepository"
            :params="['take' => 20,'filter' => ['category' => $category->id,'exclude'=>$post->id]]"
            :margin="25"
            :loops="false"
            :dots="false"
            :navText="['<i class=\'fa fa-chevron-left\'></i>','<i class=\'fa fa fa-chevron-right\'></i>']"
            mediaImage="mainimage"
            :autoplay="false"
            :responsive="[300 => ['items' =>  1],700 => ['items' =>  2], 1024 => ['items' => 3]]"
            :itemComponentAttributes="config('asgard.iblog.config.itemComponentAttributesBlog')"
          />
        </div>
      </div>
    </div>
  </div>
@stop

@section("scripts")
  @parent
  <script defer type="text/javascript"
          src="https://platform-api.sharethis.com/js/sharethis.js#property=5fd9384eb64d610011fa8357&product=inline-share-buttons"
          async="async"></script>
@stop