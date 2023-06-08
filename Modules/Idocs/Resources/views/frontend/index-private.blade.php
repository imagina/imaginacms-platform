@extends('iprofile::frontend.layouts.master')

@section('meta')
    @include('idocs::frontend.partials.category.metas')
@stop
@section('title')
    {{trans('idocs::frontend.myDocuments')}} | @parent
@stop
@section('profileTitle')
    {{trans('idocs::frontend.myDocuments')}}
@stop

@section('profileBreadcrumb')
    <x-isite::breadcrumb>
        <li class="breadcrumb-item active" aria-current="page"> {{trans('idocs::frontend.myDocuments')}}</li>
    </x-isite::breadcrumb>
@endsection

@section('profileContent')
    <div id="privateDocumentsAll" class="private-documents-all">
        <div class="container">

            <div class="row head d-none d-md-flex">
                <div class="col-12 col-md-6 title-description">
                    <span>{{trans('idocs::documents.form.title')}}</span>
                </div>
                <div class="col-12 col-md-2 size">
                    <span> {{trans('idocs::documents.form.size')}}</span>
                </div>

                <div class="col-12 col-md-2 downloaded">
                    <span> {{trans('idocs::documents.form.downloads')}}</span>
                </div>
                <div class="col-12 col-md-2 download">
                    <span> {{trans('idocs::documents.form.download')}}</span>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <livewire:isite::items-list
                            moduleName="Idocs"
                            entityName="Document"
                            :params="[
                        'filter' => [],
                        'include' => ['category'],
                        'take' => 12
                      ]"
                            :showTitle="false"
                            itemListLayout="one"
                            itemComponentName="idocs::document-list-item"
                            itemComponentNamespace="Modules\Idocs\View\Components\DocumentListItem"
                            :responsiveTopContent="['mobile' => false, 'desktop' => false]"
                    />

                </div>
            </div>
        </div>
    </div>
@stop