@extends('layouts.master')

{{-- Meta --}}
@include('iad::frontend.partials.index.meta')


@section('content')

  <div id="content_index_commerce"
       class="page icommerce icommerce-index {{isset($category->id) ? 'iad-index-category iad-index-category-'.$category->id : ''}} py-5">

    {{-- Banner Top--}}
    @include("iad::frontend.partials.banner")

    <div class="container">
      <div class="row">

        {{-- Sidebar --}}
        <div class="col-lg-3 sidebar">
          {{-- FILTERS --}}
          <livewire:isite::filters :filters="config('asgard.iad.config.filters')"/>
        </div>

        {{-- Top Content , Products, Pagination --}}
        <div class="col-lg-9">

          <livewire:isite::items-list
            moduleName="Iad"
            itemComponentName="iad::list-item"
            itemComponentNamespace="Modules\Iad\View\Components\ListItem"
            entityName="Ad"
            :title="(isset($category->id) ? $category->title : '')"
            :description="isset($category->options->descriptionIndex) && !empty($category->options->descriptionIndex) ? $category->options->descriptionIndex : null "
            :params="[
            'filter' => ['category' => $category->id ?? null],
            'include' => ['categories'],
            'take' => 12]"
            :configOrderBy="config('asgard.iad.config.orderBy')"
            :pagination="config('asgard.iad.config.pagination')"
            :configLayoutIndex="config('asgard.iad.config.layoutIndex')"/>
          <hr>
        </div>
      </div>
    </div>
  </div>
@stop