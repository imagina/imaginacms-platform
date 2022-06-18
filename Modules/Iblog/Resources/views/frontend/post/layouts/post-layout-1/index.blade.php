@extends('layouts.master')

@section('meta')
  @include('iblog::frontend.partials.post.metas')
@stop

@section('title')
  {{ $post->title }} | @parent
@stop

@section('content')
  <div class="page blog single single-{{$category->slug}} single-{{$category->id}}">
    @component('iblog.partials.blog-breadcrumb')
      @slot('title')
        {{$category->title}}
      @endslot
      @slot('image')
        {{$category->mainimage->path}}
      @endslot
      <li class="breadcrumb-item">
        <a href="{{url($category->slug)}}">{{$category->title}}</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">{{$post->title}}</li>
    @endcomponent
    <div class="container">
      {{-- article --}}
      <div class="row">
        <div class="col-12 col-md-8">
          <x-media::single-image imgClasses=""
                                 :mediaFiles="$post->mediaFiles()"
                                 :isMedia="true" :alt="$post->title"/>
          <div class="row mx-1 mx-md-3 mx-lg-4">
            <spam class="title mt-3 mb-2">{{ $post->created_at->format('d/m/Y')}}</spam>
          </div>
          <div class="row mx-1 mx-md-3 mx-lg-4">
            <h2 class="title">{{ $post->title }}</h2>
            <div class="page-body description mb-4 text-justify">
              {!! $post->description !!}
            </div>
            <div>
              <div class="social-share d-flex justify-content-end align-items-center">
                <div class="mr-2">{{trans('iblog::common.social.share')}}:</div>
                <div class="sharethis-inline-share-buttons"></div>
              </div>
            </div>
          </div>
          <h5 class="row justify-content-center font-weight-bold mt-5 mb-3">Artículos relacionados</h5>
          <x-isite::carousel.owl-carousel
            id="Articles"
            repository="Modules\Iblog\Repositories\PostRepository"
            :params="['take' => 20,'filter' => ['category' => $category->id]]"
            :margin="25"
            :loops="false"
            :dots="false"
            :nav="true"
            :navText="['<i class=\'fa fa-chevron-left\'></i>','<i class=\'fa fa fa-chevron-right\'></i>']"
            mediaImage="mainimage"
            :autoplay="false"
            :responsive="[300 => ['items' =>  1],700 => ['items' =>  2], 1024 => ['items' => 2]]"
            :componentItemAttributes="[
                                    'withViewMoreButton'=>true,
                                    'withCategory'=>false,
                                    'withSummary'=>true,
                                    'withCreatedDate'=>true,
                                    'layout'=>'item-list-layout-6',
                                    'imageAspect'=>'4/3',
                                    'imageObject'=>'cover',
                                    'imageBorderRadio'=>'0',
                                    'imageBorderStyle'=>'solid',
                                    'imageBorderWidth'=>'0',
                                    'imageBorderColor'=>'#000000',
                                    'imagePadding'=>'0',
                                    'withTitle'=>true,
                                    'titleAlign'=>'',
                                    'titleTextSize'=>'18',
                                    'titleTextWeight'=>'font-weight-bold',
                                    'titleTextTransform'=>'',
                                    'formatCreatedDate'=>'d/m/Y',
                                    'summaryAlign'=>'text-left',
                                    'summaryTextSize'=>'16',
                                    'summaryTextWeight'=>'font-weight-normal',
                                    'numberCharactersSummary'=>'100',
                                    'categoryAlign'=>'text-left',
                                    'categoryTextSize'=>'18',
                                    'categoryTextWeight'=>'font-weight-normal',
                                    'createdDateAlign'=>'text-left',
                                    'createdDateTextSize'=>'12',
                                    'createdDateTextWeight'=>'font-weight-normal',
                                    'buttonAlign'=>'text-left',
                                    'buttonLayout'=>'',
                                    'buttonIcon'=>'fa fa-angle-right',
                                    'buttonIconLR'=>'left',
                                    'buttonColor'=>'dark',
                                    'viewMoreButtonLabel'=>'icustom::common.post.labelViewMore',
                                    'withImageOpacity'=>false,
                                    'imageOpacityColor'=>'opacity-dark',
                                    'imageOpacityDirection'=>'opacity-all',
                                    'orderClasses'=>[
                                    'photo'=>'order-0',
                                    'title'=>'order-2',
                                    'date'=>'order-1',
                                    'categoryTitle'=>'order-3',
                                    'summary'=>'order-3',
                                    'viewMoreButton'=>'order-5'
                                    ],
                                    'imagePosition'=>'1',
                                    'imagePositionVertical'=>'align-self-center',
                                    'contentPositionVertical'=>'align-self-center',
                                    'contentPadding'=>'0',
                                    'contentBorder'=>'0',
                                    'contentBorderColor'=>'#ffffff',
                                     'contentBorderRounded'=>'0',
                                    'contentMarginInsideX'=>'mx-lg-4 mx-md-1 mx-0',
                                    'contentBorderShadows'=>'none',
                                    'contentBorderShadowsHover'=>'',
                                    'titleColor'=>'text-dark',
                                    'summaryColor'=>'text-dark',
                                    'categoryColor'=>'text-primary',
                                    'createdDateColor'=>'text-dark',
                                    'titleMarginT'=>'mt-3 mt-md-4 mt-lg-3',
                                    'titleMarginB'=>'mb-3 mb-md-4 mb-md-2',
                                    'summaryMarginT'=>'mt-lg-2 mt-0',
                                    'summaryMarginB'=>'mb-0',
                                    'categoryMarginT'=>'mt-0',
                                    'categoryMarginB'=>'mb-0',
                                    'categoryOrder'=>'3',
                                    'createdDateMarginT'=>'mt-1',
                                    'createdDateMarginB'=>'mb-0',
                                    'createdDateOrder'=>'1',
                                    'buttonMarginT'=>'mt-md-1 mt-0',
                                    'buttonMarginB'=>'mb-2',
                                    'buttonOrder'=>'5',
                                    'titleLetterSpacing'=>'0',
                                    'summaryLetterSpacing'=>'0',
                                    'categoryLetterSpacing'=>'0',
                                    'createdDateLetterSpacing'=>'0',
                                    'titleVineta'=>'',
                                    'titleVinetaColor'=>'text-dark',
                                    'buttonSize'=>'button-normal',
                                    'buttonTextSize'=>'14',
                                    'itemBackgroundColor'=>'#ffffff',
                                    'itemBackgroundColorHover'=>'#ffffff',
                                    'titleHeight'=>'20',
                                    'summaryHeight'=>'90'
                                    ]"
          />
        </div>
        {{-- Sidebar --}}
        <div class="col-12 col-md-4 px-1">
          <div class="row mx-1">
            <div class="col-12 my-2">
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
          </div>
          <div class="row mx-1">
            <div class="col-12">
              <h4 class="mt-1 mb-3 ml-3">{{trans('icustom::common.post.titlePostRecent')}}</h4>
              <livewire:isite::items-list
                moduleName="Iblog"
                itemComponentName="isite::item-list"
                itemComponentNamespace="Modules\Isite\View\Components\ItemList"
                :configLayoutIndex="['default' => 'one',
                                                            'options' => [
                                                                'one' => [
                                                                    'name' => 'one',
                                                                    'class' => 'col-12 my-3 pl-md-5',
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
                                        'viewMoreButtonLabel'=>'isite::common.menu.labelViewMore',
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
                                        'categoryColor'=>'text-primary',
                                        'createdDateColor'=>'text-dark',
                                        'titleMarginT'=>'mt-0',
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
                                        'titleHeight'=>40,
                                        'summaryHeight'=>100,
                                            ]"
                entityName="Post"
                :showTitle="false"
                :pagination="['show'=>false]"

                :params="['take'=>5,'filter' => ['category' => $category->id ?? null]]"
                :responsiveTopContent="['mobile'=>false,'desktop'=>false]"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop