@extends('iprofile::frontend.layouts.master')
@section('profileBreadcrumb')
    <x-isite::breadcrumb>
        <li class="breadcrumb-item active" aria-current="page">{{ trans('iplan::common.title.my-subscriptions') }}</li>
    </x-isite::breadcrumb>
@endsection

@section('profileTitle')
    {{ trans('iplan::common.title.my-subscriptions') }}
@endsection
@section('profileContent')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <livewire:isite::items-list
                        moduleName="Iplan"
                        entityName="Subscription"
                        itemComponentName="iplan::subscription-list-item"
                        itemComponentNamespace="Modules\Iplan\View\Components\SubscriptionListItem"
                        :configLayoutIndex="array_merge(config('asgard.iblog.config.layoutIndex'),['default' => 'four'])"
                        :showTitle="false"
                        :params="['take' => 12,'filter' => ['user'=>$user->id]]"
                        :responsiveTopContent="['mobile'=>false,'desktop'=>false]"
                        :itemComponentAttributes="[
                            'margin' => 0,
                            'formatCreatedDate' => 'd \d\e F \d\e Y',
                        ]"
                />
            </div>
        </div>
    </div>
@endsection
