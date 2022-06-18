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
          <h5 class="title-category">{{ $category->title }}</h5>
          <h3 class="title">{{ $post->title }}</h3>
          <div class="mb-3 mt-2">
            {{$post->summary }}
          </div>
          <div class="my-1">
            <x-media::single-image imgClasses="rounded"
                                   :mediaFiles="$post->mediaFiles()"
                                   :isMedia="true" :alt="$post->title"/>
          </div>
          <div class="create-date my-4">
            {{ $post->created_at->format('d \d\e M,Y')}}
          </div>
          <div class="row">
            <div class="col-12 col-lg-2 px-lg-5 mb-3">
              <x-isite::social/>
            </div>
            <div class="col-12 col-lg-10">
              <div class="page-body description mb-4 text-justify">
                {!! $post->description !!}
              </div>
            </div>
          </div>
          <div class="mb-5">
            <h5 class="mt-5 mb-3">Artículos relacionados</h5>
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
              :withViewMoreButton="false"
              :withSummary="false"
              :responsive="[300 => ['items' =>  1],700 => ['items' =>  2], 1024 => ['items' => 3]]"
              :withCategory="true"
              :withCreatedDate="true"
              layout="item-list-layout-6"
              imageAspect="3/2"
              imageObject="cover"
              imageBorderRadio="0"
              imageBorderStyle="solid"
              imageBorderWidth="0"
              imageBorderColor="#000000"
              imagePadding="0"
              :withTitle="true"
              titleAlign=""
              titleTextSize="14"
              titleTextWeight="font-weight-bold"
              titleTextTransform=""
              formatCreatedDate="d \d\e M,Y"
              summaryAlign="text-left"
              summaryTextSize="16"
              summaryTextWeight="font-weight-normal"
              numberCharactersSummary="88"
              categoryAlign="text-left"
              categoryTextSize="10"
              categoryTextWeight="font-weight-normal"
              createdDateAlign="text-left"
              createdDateTextSize="11"
              createdDateTextWeight="font-weight-normal"
              buttonAlign="text-left"
              buttonLayout="rounded-pill"
              buttonIcon=""
              buttonIconLR="left"
              buttonColor="dark"
              viewMoreButtonLabel="isite::common.menu.viewMore"
              :withImageOpacity="false"
              imageOpacityColor="opacity-dark"
              imageOpacityDirection="opacity-top"
              :orderClasses="[ 'photo'=>'order-0',
                                                'title'=>'order-3',
                                                'date'=>'order-3',
                                                'categoryTitle'=>'order-1',
                                                'summary'=>'order-2',
                                                'viewMoreButton'=>'order-5'
                                                ]"
              imagePosition="1"
              imagePositionVertical="align-self-center"
              contentPositionVertical="align-self-center"
              contentPadding="0"
              contentBorder="0"
              contentBorderColor="#dddddd"
              contentBorderRounded="0"
              contentMarginInsideX="mx-1"
              contentBorderShadows="none"
              contentBorderShadowsHover=""
              titleColor="text-dark"
              summaryColor="text-dark"
              categoryColor="text-dark"
              createdDateColor="text-dark"
              titleMarginT="mt-1"
              titleMarginB="mb-1"
              summaryMarginT="mt-0"
              summaryMarginB="mb-2"
              categoryMarginT="mt-3"
              categoryMarginB="mb-1"
              categoryOrder="1"
              createdDateMarginT="mt-1"
              createdDateMarginB="mb-2"
              createdDateOrder="3"
              buttonMarginT="mt-1"
              buttonMarginB="mb-1"
              buttonOrder="5"
              titleLetterSpacing="0"
              summaryLetterSpacing="0"
              categoryLetterSpacing="0"
              createdDateLetterSpacing="0"
              titleVineta=""
              titleVinetaColor="text-dark"
              buttonSize="button-normal"
              buttonTextSize="16"
              itemBackgroundColor="#ffffff"
              itemBackgroundColorHover="#ffffff"
              titleHeight=30
              summaryHeight=80
              columnLeft=col-lg-6
              columnRight=col-lg-6
              titleTextDecoration=none
              summaryTextDecoration=none
              categoryTextDecoration=none
              createdDateTextDecoration=none
            />
          </div>
        </div>
        {{-- Sidebar --}}
        <div class="sidebar col-12 col-md-4 px-5">
          <div class="row">
            <div class="col-12 my-2 pl-lg-5">
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
            <div class="row">
              <div class="col-12 pl-lg-5">
                <h4 class="mt-1 mb-2 mx-3">{{trans('icustom::common.post.titlePostRecent')}}</h4>
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
                                        'viewMoreButtonLabel'=>'isite::common.menu.viewMore',
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
                                        'contentBorderColor'=>'#e3e3e3',
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

                  :params="['take'=>3,'filter' => ['category' => $category->id ?? null]]"
                  :responsiveTopContent="['mobile'=>false,'desktop'=>false]"
                />
              </div>
            </div>
          </div>
          <div class="tag pl-lg-5">
            @if(!$tags->isEmpty())
              <br>
              <p>{{trans('icustom::common.post.titleTags')}}</p>
              <span class="tags-links my-2">
                                @foreach($tags as $tag)
                  <a class="btn btn-primary m-1"
                     href="{{route(locale(). '.iblog.tag.slug',['slug' => $tag->slug])}}"
                     rel="tag">{{$tag->name}}
                                    </a>
                @endforeach
                            </span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
