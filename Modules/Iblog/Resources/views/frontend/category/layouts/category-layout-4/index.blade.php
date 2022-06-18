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
        <div class="row">

          <div class="sidebar col-12 col-md-3">
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

          {{-- Top Content , Products, Pagination --}}
          <div class="posts col-12 col-md-9">
            <h5 class="ml-3 my-1">Artículos</h5>
            <livewire:isite::items-list
              moduleName="Iblog"
              itemComponentName="isite::item-list"
              itemComponentNamespace="Modules\Isite\View\Components\ItemList"
              :configLayoutIndex="['default' => 'two',
                                                        'options' => [
                                                            'two'=> [
                                                                'name' => 'two',
                                                                'class' => 'col-12 col-md-6 col-lg-4 my-3',
                                                                'icon' => 'fa fa-square-o',
                                                                'status' => true],
                                                                ]
                                                                ]"
              :itemComponentAttributes="[
                                    'withViewMoreButton'=>true,
                                    'withCategory'=>false,
                                    'withSummary'=>true,
                                    'withCreatedDate'=>true,
                                    'layout'=>'item-list-layout-6',
                                    'imageAspect'=>'3/2',
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
                                    'formatCreatedDate'=>'d \d\e M,Y',
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
                                    'buttonLayout'=>'rounded-pill',
                                    'buttonIcon'=>'',
                                    'buttonIconLR'=>'left',
                                    'buttonColor'=>'dark',
                                    'viewMoreButtonLabel'=>'icustom::common.post.labelButton',
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
                                    'contentMarginInsideX'=>'mx-lg-3 mx-md-1 mx-0',
                                    'contentBorderShadows'=>'none',
                                    'contentBorderShadowsHover'=>'',
                                    'titleColor'=>'text-dark',
                                    'summaryColor'=>'text-dark',
                                    'categoryColor'=>'text-primary',
                                    'createdDateColor'=>'text-dark',
                                    'titleMarginT'=>'mt-3 mt-md-4 mt-lg-3',
                                    'titleMarginB'=>'mb-3 mb-md-4 mb-md-3',
                                    'summaryMarginT'=>'mt-md-2 mt-0',
                                    'summaryMarginB'=>'mb-md-4 mb-0',
                                    'categoryMarginT'=>'mt-0',
                                    'categoryMarginB'=>'mb-0',
                                    'categoryOrder'=>'3',
                                    'createdDateMarginT'=>'mt-2',
                                    'createdDateMarginB'=>'mb-2 mb-md-3',
                                    'createdDateOrder'=>'1',
                                    'buttonMarginT'=>'mt-2',
                                    'buttonMarginB'=>'mb-3 ',
                                    'buttonOrder'=>'5',
                                    'titleLetterSpacing'=>'0',
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
              entityName="Post"
              :showTitle="false"
              :params="['filter' => ['category' => $category->id ?? null],'take'=>9]"
              :responsiveTopContent="['mobile'=>false,'desktop'=>false]"
            />
          </div>

        </div>
      </div>
      <!-- /.row -->
    </div>
  </section>
@stop
