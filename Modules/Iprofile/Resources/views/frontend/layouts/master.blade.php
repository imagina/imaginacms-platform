@extends('layouts.master')



@section('content')
  @yield('profileBreadcrumb')
  
  
  {{-- Need Publish --}}
  
  <div id="indexProfile" class="page page-profile">
    <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
    
    <div class="container">
      <div class="row">
        
        <div class="col-lg-4 col-xl-3 mb-3">
          
          {{--################# MENU #################--}}
          <x-iprofile::user-menu layout="user-menu-layout-2" :onlyShowInTheDropdownHeader="false"
                                 :onlyShowInTheMenuOfTheIndexProfilePage="true"/>
        
        </div> {{-- End col --}}
        
        <div class="col-lg-8 col-xl-9 mb-5">
          <div class="title border-bottom border-top-dotted border-bottom-dotted py-2 mb-2">
            <h1 class="h4 my-0text-primary">
              @yield('profileTitle')
            </h1>
          </div>
         @yield('profileContent')
        
        </div> {{-- End col --}}
      
      </div>
    </div>
  
  </div>
@stop

@yield('profileExtraFooter')
