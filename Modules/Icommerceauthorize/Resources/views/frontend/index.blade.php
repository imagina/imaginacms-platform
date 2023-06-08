@extends('layouts.master')

@section('title')
  Authorize.net | @parent
@stop


@section('content')
<div class="icommerce_authorize_index">
    <div class="container">

       @include('icommerceauthorize::frontend.partials.header')

      <div class="row my-5 justify-content-center">
  
         @include('icommerceauthorize::frontend.partials.modal')
  
      </div>
  
      @include('icommerceauthorize::frontend.partials.footer')
  
    </div>
</div>
@stop