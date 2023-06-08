@extends('layouts.master')

@section('meta')
    @if(isset($category->id))
        @include('idocs::frontend.partials.category.metas')
    @endif
@stop
@section('title')
    {{trans('idocs::frontend.publicDocuments')}} | @parent
@stop
@section('content')
    
    <x-isite::breadcrumb>
        <li class="breadcrumb-item active" aria-current="page"> {{trans('idocs::frontend.publicDocuments')}}</li>
    </x-isite::breadcrumb>
    
    <div  id="publicDocumentsAll" class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="docs-title h3">{{isset($category->id) ? $category->title : ''}}</h1>
            </div>
            @if(isset($category->id))
            <div class="col-12">
                <livewire:isite::items-list
                  moduleName="Idocs"
                  entityName="Document"
                  itemComponentNamespace="Modules\Idocs\View\Components\DocumentListItem"
                  :params="[
                    'filter' => [ 'categoryId' => $category->id ],
                    'include' => [],
                    'take' => 12
                  ]"
                  :showTitle="false"
                  itemListLayout="one"
                  itemComponentName="idocs::document-list-item"
                  :responsiveTopContent="['mobile' => false, 'desktop' => false]"
                />
            </div>
            @endif
            <div class="col-12">
                <livewire:isite::items-list
                  moduleName="Idocs"
                  itemComponentName="idocs::category-list-item"
                  itemComponentNamespace="Modules\Idocs\View\Components\CategoryListItem"
                  entityName="Category"
                  :params="[
						'filter' => ['private' => false, 'parentId' => $category->id ?? null],
						'include' => [],
						'take' => 12
					]"
                  :showTitle="false"
                  itemListLayout="one"
                  :responsiveTopContent="['mobile' => false, 'desktop' => false]"
                />
            </div>
            
        </div>
        
    </div>
   
@stop