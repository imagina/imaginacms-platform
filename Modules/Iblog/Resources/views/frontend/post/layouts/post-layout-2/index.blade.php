@extends('layouts.master')

@section('meta')
  @include('iblog::frontend.partials.post.metas')
@stop

@section('title')
  {{ $post->title }} | @parent
@stop
@section('content')
  <div id="postLayout2" class="page blog single single-{{$category->slug}} single-{{$category->id}}">
    @include('iblog::frontend.partials.breadcrumb')
    <div class="container">
      {{-- article --}}
      <div class="row">
        <div class="col-12 col-md-8">
          <h5 class="title-category">{{ $category->title }}</h5>
          <h1 class="title h3">{{ $post->title }}</h1>
          <div class="mb-3 mt-2">
            {{$post->summary }}
          </div>
          <div class="my-1">
            <x-media::single-image imgClasses="rounded"
                                   :mediaFiles="$post->mediaFiles()"
                                   :isMedia="true" :alt="$post->title"/>
          </div>
          <div class="create-date my-4">
            {{ $post->created_at->format('d \d\e M, Y')}}
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
        </div>
        {{-- Sidebar --}}
        <div class="sidebar col-12 col-md-4 pl-lg-5">
          <div class="blog-categories">
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
          <div class="blog-recent mb-4">
             <h4 class="mb-3">{{trans('iblog::common.layouts.titlePostRecent')}}</h4>
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
                                        'formatCreatedDate'=>'d \d\e M, Y',
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
                                        'titleMarginB'=>'mb-1 mb-lg-0',
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
                                        'columnLeft'=>'col-4 col-sm-5',
                                        'columnRight'=>'col-8 col-sm-7 pr-0',
                                        'titleTextSizeMobile'=>'14',
                                            ]"
                  entityName="Post"
                  :showTitle="false"
                  :pagination="['show'=>false]"
                  :params="['take'=>3,'filter' => ['category' => $category->id ?? null]]"
                  :responsiveTopContent="['mobile'=>false,'desktop'=>false]"
                />
          </div>
          <div class="blog-tag mb-4">
            <x-tag::tags :item="$post"/>
          </div>
        </div>
      </div>
      <div class="blog-related my-5">
        <h5 class="mb-3 font-weight-bold">{{trans('iblog::common.layouts.titleRelatedPosts')}}</h5>
        <x-isite::carousel.owl-carousel
          id="Articles"
          repository="Modules\Iblog\Repositories\PostRepository"
          :params="['take' => 20,'filter' => ['category' => $category->id,'exclude'=>$post->id]]"
          :margin="25"
          :loops="false"
          :dots="false"
          mediaImage="mainimage"
          :responsive="[300 => ['items' =>  1],700 => ['items' =>  2], 1024 => ['items' => 3]]"
          :itemComponentAttributes="config('asgard.iblog.config.itemComponentAttributesBlog')"
        />
      </div>
    </div>
  </div>
@stop
