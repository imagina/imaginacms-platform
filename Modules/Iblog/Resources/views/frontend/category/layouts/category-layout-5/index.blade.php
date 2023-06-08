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
  <div id="categoryLayout5"
       class="  {{isset($category->id) ? 'iblog-index-category iblog-index-category-'.$category->id.' blog-category-'.$category->id : ''}} py-5">
    @include('iblog::frontend.partials.breadcrumb')
    <div class="container">
      <div class="title my-1">
        <h1 class="title h4">{{isset($category->title) ? $category->title : ""}}</h1>
      </div>
      <div class="description pt-3">
        {!! isset($category->description) ? $category->description : "" !!}
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
            :itemComponentAttributes="config('asgard.iblog.config.itemComponentAttributesBlog')"
            entityName="Post"
            :showTitle="false"
            :params="['filter' => ['category' => $category->id ?? null],'take' => 12]"
            :responsiveTopContent="['mobile'=>false,'desktop'=>false]"
          />
        </div>
      </div>
    </div>
  </div>
@stop