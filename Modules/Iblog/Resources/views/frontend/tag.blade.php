@extends('layouts.master')

@section('meta')
  @if(isset($tag->id))
    @include('iblog::frontend.partials.tag.metas')
  @endif
@stop
@section('title')
  {{isset($tag->name)? $tag->name: trans("iblog::routes.blog.index.index")}}  | @parent
@stop
@section('content')
  <div id="content_index_blog"
       class="  {{isset($tag->id) ? 'iblog-index-tag iblog-index-tag-'.$tag->id.' blog-tag-'.$tag->id : ''}} py-5">
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
            @include('iblog::frontend.partials.children-categories-index-section',["category" => $category ?? null,"tag" => $tag ?? null])
          @endif
          
          <livewire:isite::items-list
          moduleName="Iblog"
          itemComponentName="isite::item-list"
          itemComponentNamespace="Modules\Isite\View\Components\ItemList"
          :configLayoutIndex="config('asgard.iblog.config.layoutIndex')"
          :itemComponentAttributes="config('asgard.iblog.config.indexItemListAttributes')"
          entityName="Post"
          :showTitle="true"
          :params="['filter' => ['tagId' => $tag->id ?? '']]"
          :responsiveTopContent="['mobile'=>false,'desktop'=>false]"
        />

        </div>

      </div>
      <!-- /.row -->
    
    </div>
  </div>
@stop
