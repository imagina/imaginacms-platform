@extends('layouts.master')
@section('title')
  {{$tag->name}} | @parent
@stop
@section('content')

  <div id="pageTags" class="page blog tags pt-5">
    <div class="container">
      <h1 class="page-header col-12">{{$tag->name}}</h1>
      <br>
      <div class="row justify-content-center">
        <livewire:isite::items-list
          moduleName="Tag"
          itemComponentName="isite::item-list"
          itemComponentNamespace="Modules\Isite\View\Components\ItemList"
          :configLayoutIndex="config('asgard.tag.config.layoutIndex')"
          :itemComponentAttributes="config('asgard.tag.config.indexItemListAttributes')"
          entityName="Tag"
          :showTitle="false"
          :pagination="['show' => false]"
          :params="['filter' => ['tagId' => $tag->id ?? null, 'withoutInternal' => true]]"
          :responsiveTopContent="['mobile'=>false,'desktop'=>false]"
        />
      </div>
    </div>
    <br>
  </div>
@stop
