@extends('layouts.master')

@section('meta')
  @if(isset($category->id))
    @include('iblog::frontend.partials.category.metas')
  @endif
@stop
@section('title')
  {{isset($category->title)? $category->title: trans("iblog::routes.blog.index.index")}}  | @parent
@stop
@section('content')
  <section id="layout2"
           class="  {{isset($category->id) ? 'iblog-index-category iblog-index-category-'.$category->id.' blog-category-'.$category->id : ''}} py-5">
    <div id="content_index_blog"
         class="  {{isset($category->id) ? 'iblog-index-category iblog-index-category-'.$category->id.' blog-category-'.$category->id : ''}} py-5">
      <div class="container">
        <div class="row">
          @include('iblog::frontend.partials.breadcrumb')
        </div>
      </div>
      <div class="container">
        <div class="title my-1">
          <h3>
            {{isset($category->title) ? $category->title : ""}}
          </h3>
          <h4 class="title">{!! $category->description  !!}</h4>
        </div>
        <div class="row">
          <div class="col-12">
            <livewire:isite::items-list
              moduleName="Iblog"
              itemComponentName="isite::item-list"
              itemComponentNamespace="Modules\Isite\View\Components\ItemList"
              :configLayoutIndex="['default' => 'three',
                                                        'options' => [
                                                            'three'=> [
                                                                'name' => 'three',
                                                                'class' => 'col-12 col-md-6 col-lg-4 my-3',
                                                                'icon' => 'fa fa-square-o',
                                                                'status' => true],
                                                                ]
                                                                ]"
              :itemComponentAttributes="['withViewMoreButton' => false,
                                    'withCategory'=>false,
                                    'withSummary'=>true,
                                    'withCreatedDate'=>true,
                                    'layout'=>'item-list-layout-6',
                                    'imageAspect'=>'1/1',
                                    'imageObject'=>'cover',
                                    'imageBorderRadio'=>'18',
                                    'imageBorderStyle'=>'solid',
                                    'imageBorderWidth'=>'0',
                                    'imageBorderColor'=>'#000000',
                                    'imagePadding'=>'0',
                                    'withTitle'=>true,
                                    'titleAlign'=>'',
                                    'titleTextSize'=>'22',
                                    'titleTextWeight'=>'font-weight-bold',
                                    'titleTextTransform'=>'',
                                    'formatCreatedDate'=>'d \d\e M,Y',
                                    'summaryAlign'=>'text-left',
                                    'summaryTextSize'=>'14',
                                    'summaryTextWeight'=>'font-weight-normal',
                                    'numberCharactersSummary'=>'160',
                                    'categoryAlign'=>'text-left',
                                    'categoryTextSize'=>'14',
                                    'categoryTextWeight'=>'font-weight-normal',
                                    'createdDateAlign'=>'text-left',
                                    'createdDateTextSize'=>'12',
                                    'createdDateTextWeight'=>'font-weight-normal',
                                    'buttonAlign'=>'text-left',
                                    'buttonLayout'=>'',
                                    'buttonIcon'=>'fa fa-angle-right',
                                    'buttonIconLR'=>'left',
                                    'buttonColor'=>'dark',
                                    'viewMoreButtonLabel'=>'icustom::common.post.viewMore',
                                    'withImageOpacity'=>'false',
                                    'imageOpacityColor'=>'opacity-dark',
                                    'imageOpacityDirection'=>'opacity-all',
                                    'orderClasses'=>[
                                    'photo'=>'order-0',
                                    'title'=>'order-2',
                                    'date'=>'order-1',
                                    'categoryTitle'=>'order-4',
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
                            'contentMarginInsideX'=>'mx-4 mx-md-2 mx-lg-4',
                            'contentBorderShadows'=>'0 .125rem .25rem rgba(0,0,0,.075)',
                            'contentBorderShadowsHover'=>'',
                            'titleColor'=>'text-dark',
                            'summaryColor'=>'text-dark',
                            'categoryColor'=>'text-dark',
                            'createdDateColor'=>'text-dark',
                            'titleMarginT'=>'mt-0',
                            'titleMarginB'=>'mb-1',
                            'summaryMarginT'=>'mt-1 mt-md-1',
                            'summaryMarginB'=>'mb-2 mb-md-2',
                            'categoryMarginT'=>'mt-1 mt-md-3',
                            'categoryMarginB'=>'mb-1 mt-md-2',
                            'categoryOrder'=>'4',
                            'createdDateMarginT'=>'mt-3',
                            'createdDateMarginB'=>'mb-1',
                            'createdDateOrder'=>'1',
                            'buttonMarginT'=>'mt-md-0 mt-4',
                            'buttonMarginB'=>'mb-md-2 mb-2',
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
                            'titleHeight'=>'50',
                            'summaryHeight'=>'100'
                                    ]"
              entityName="Post"
              :showTitle="false"
              :params="['filter' => ['category' => $category->id ?? null],'take' => 12]"
              :responsiveTopContent="['mobile'=>false,'desktop'=>false]"
            />
          </div>
        </div>
      </div>
    </div>
  </section>
@stop