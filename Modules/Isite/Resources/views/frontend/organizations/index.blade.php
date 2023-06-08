@extends('layouts.master')

@section('title')
  {{isset($category->title)? $category->title: trans("isite::organizations.plural")}}  | @parent
@stop

@section('content')


<div class="page isite isite-organizations isite-organizations-index py-5 {{isset($category->id) ? 'isite-organizations-index-category isite-organizations-index-category-'.$category->id : ''}}">

	<div class="container">

		<div class="row">

     
      <div class="col-lg-12">
         
        <livewire:isite::items-list 
            moduleName="Isite"
            itemComponentName="isite::item-list"
            itemComponentNamespace="Modules\Isite\View\Components\ItemList"
            entityName="Organization"
            :configLayoutIndex="config('asgard.isite.config.organizations.layoutIndex')"
            :itemComponentAttributes="config('asgard.isite.config.organizations.indexItemListAttributes')"
            :params="[
            'filter' => ['category' => $category->id ?? null],
            'include' => ['translations','category'], 
            'take' => setting('icommerce::product-per-page',null,12)]"
            :responsiveTopContent="['mobile'=>false,'desktop'=>false]"
            :pagination="config('asgard.isite.config.organizations.pagination')"
            :title="$title"
            />

          <hr>
        
        </div>
      
      </div>
    </div>
  
</div>

@stop