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
  <div id="categoryLayout4"
       class="  {{isset($category->id) ? 'iblog-index-category iblog-index-category-'.$category->id.' blog-category-'.$category->id : ''}} py-5">
    @include('iblog::frontend.partials.breadcrumb')
    <div class="container">
      <h1>
        {{ $category->title }}
      </h1>
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
                                                                'emitTo' => false,
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
            :itemComponentAttributes="config('asgard.iblog.config.itemComponentAttributesBlog')"
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
@stop
