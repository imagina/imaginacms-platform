@extends('layouts.master')

@section('meta')
  @include('iblog::frontend.partials.post.metas')
@stop

@section('title')
  {{ $post->title }} | @parent
@stop
@section('content')
  <section id="layout4"
           class="  {{isset($category->id) ? 'iblog-index-category iblog-index-category-'.$category->id.' blog-category-'.$category->id : ''}} py-2">
    <div id="content_index_blog"
         class="  {{isset($category->id) ? 'iblog-index-category iblog-index-category-'.$category->id.' blog-category-'.$category->id : ''}} py-2">
      <div class="container">
        <div class="row">
          @include('iblog::frontend.partials.breadcrumb')
        </div>
      </div>
      <div class="page blog single single-{{$category->slug}} single-{{$category->id}}">

        <div class="container">
          <div class="row">
            {{--sidebar--}}
            <div class="col-12 col-md-3">
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
            {{--article--}}
            <div class="col-12 col-md-9 p-md-4">
              <h3 class="title">{{ $post->title }}</h3>
              <div class="my-1">
                <x-media::single-image imgClasses=""
                                       :mediaFiles="$post->mediaFiles()"
                                       :isMedia="true" :alt="$post->title"/>
              </div>
              <div class="create-date my-4">
                {{ $post->created_at->format('d \d\e M,Y')}}
              </div>
              <div class="page-body description my-4 text-justify">
                {!! $post->description !!}
              </div>
              <div class="social-share d-flex justify-content-start align-items-center my-5">
                <div class="mr-2">{{trans('iblog::common.social.share')}}:</div>
                <div class="sharethis-inline-share-buttons"></div>
              </div>
              <div class="mb-5">
                <h5>Artículos relacionados</h5>
                <x-isite::carousel.owl-carousel
                  id="Articles"
                  repository="Modules\Iblog\Repositories\PostRepository"
                  :params="['take' => 20,'filter' => ['category' => $category->id]]"
                  :margin="30"
                  :loops="false"
                  :dots="false"
                  :nav="false"
                  mediaImage="mainimage"
                  :autoplay="false"
                  :withViewMoreButton="true"
                  :withSummary="true"
                  :withCreatedDate="true"
                  :responsive="[300 => ['items' =>  1],700 => ['items' =>  2], 1024 => ['items' => 3]]"
                  :withCategory="false"
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
                  titleTextSize="16"
                  titleTextWeight="font-weight-bold"
                  titleTextTransform=""
                  formatCreatedDate="d \d\e M, Y"
                  summaryAlign="text-left"
                  summaryTextSize="16"
                  summaryTextWeight="font-weight-normal"
                  numberCharactersSummary="88"
                  categoryAlign="text-left"
                  categoryTextSize="18"
                  categoryTextWeight="font-weight-normal"
                  createdDateAlign="text-left"
                  createdDateTextSize="14"
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
                  :orderClasses="['photo'=>'order-0',
                                                        'title'=>'order-2',
                                                        'date'=>'order-1',
                                                        'categoryTitle'=>'order-3',
                                                        'summary'=>'order-2',
                                                        'viewMoreButton'=>'order-5'
                                                        ]"
                  imagePosition="1"
                  imagePositionVertical="align-self-center"
                  contentPositionVertical="align-self-center"
                  contentPadding="0"
                  contentBorder="0"
                  contentBorderColor="#e3e3e3"
                  contentBorderRounded="0"
                  contentMarginInsideX="mx-3"
                  contentBorderShadows="none"
                  contentBorderShadowsHover=""
                  titleColor="text-dark"
                  summaryColor="text-dark"
                  categoryColor="text-primary"
                  createdDateColor="text-dark"
                  titleMarginT="mt-1 mt-lg-2"
                  titleMarginB="mb-1 mb-lg-3"
                  summaryMarginT="mt-1"
                  summaryMarginB="mb-0 mb-md-2"
                  categoryMarginT="mt-0"
                  categoryMarginB="mb-2"
                  categoryOrder="3"
                  createdDateMarginT="mt-3"
                  createdDateMarginB="mb-2"
                  createdDateOrder="1"
                  buttonMarginT="mt-1 mt-md-2 mt-lg-3"
                  buttonMarginB="mb-3"
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
                  titleHeight=40
                  summaryHeight=90
                  columnLeft=col-lg-6
                  columnRight=col-lg-6
                  titleTextDecoration=none
                  summaryTextDecoration=none
                  categoryTextDecoration=none
                  createdDateTextDecoration=none
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@stop