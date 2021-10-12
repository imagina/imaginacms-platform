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
  <div id="content_index_blog"
       class="  {{isset($category->id) ? 'iblog-index-category iblog-index-category-'.$category->id.' blog-category-'.$category->id : ''}} py-5">
    <div class="container">
      <div class="row">
        @include('iblog::frontend.partials.breadcrumb')
      </div>
    </div>
    <div class="container">
      
      <div class="row">
        {{-- Sidebar --}}
        <div class="sidebar {{config('asgard.iblog.config.customClassesToTheIndexCols.sidebar')}}">
          {{-- Custom Includes --}}
          @if(config("asgard.iblog.config.customIncludesBeforeFilters"))
            @foreach(config("asgard.iblog.config.customIncludesBeforeFilters") as $view)
              @include($view)
            @endforeach
          @endif
          <livewire:isite::filters :filters="config('asgard.iblog.config.filters')"/>
  
  
          {{-- Custom Includes --}}
          @if(config("asgard.iblog.config.customIncludesAfterFilters"))
            @foreach(config("asgard.iblog.config.customIncludesAfterFilters") as $view)
              @include($view)
            @endforeach
          @endif
        </div>
  
  
        {{-- Top Content , Products, Pagination --}}
        <div class="posts {{config('asgard.iblog.config.customClassesToTheIndexCols.posts')}}">
  
          @if(setting("iblog::showCategoryChildrenIndexHeader"))
            @include('iblog::frontend.partials.children-categories-index-section',["category" => $category ?? null])
          @endif
          
          <livewire:isite::items-list
          moduleName="Iblog"
          itemComponentName="isite::item-list"
          itemComponentNamespace="Modules\Isite\View\Components\ItemList"
          :configLayoutIndex="config('asgard.iblog.config.layoutIndex')"
          :itemComponentAttributes="config('asgard.iblog.config.indexItemListAttributes')"
          entityName="Post"
          :showTitle="true"
          :params="['filter' => ['category' => $category->id ?? null, 'withoutInternal' => true]]"
          :responsiveTopContent="['mobile'=>false,'desktop'=>false]"
        />

        </div>

      </div>
      <!-- /.row -->
    
    </div>
  </div>
@stop
