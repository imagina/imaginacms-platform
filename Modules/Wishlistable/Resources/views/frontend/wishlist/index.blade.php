@extends('iprofile::frontend.layouts.master')


@section('title')
  {{trans("wishlistable::wishlistables.title.myWishlist")}}   | @parent
@stop


@section('profileTitle')
  {{trans("wishlistable::wishlistables.title.myWishlist")}}
@stop

@section('profileBreadcrumb')
  <x-isite::breadcrumb>
    <li class="breadcrumb-item active" aria-current="page">{{trans("wishlistable::wishlistables.title.wishlist")}}</li>
  </x-isite::breadcrumb>
@endsection
@section('profileContent')
  
  <div id="contentWishlist" class="row">
    <div class="col-lg-12  pb-5">
      <div id="cont_products" class="mt-4">
       <livewire:wishlistable::wishlistable />
      
      </div>
    </div>
  </div>

  @stop



