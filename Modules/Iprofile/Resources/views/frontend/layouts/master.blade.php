@extends('layouts.master')

@section('content')
  {{-- Need Publish --}}

  <div id="indexProfile" class="page page-profile position-relative">
    <div class="overlay"></div>
    @yield('profileBreadcrumb')

    <div class="sidebar-profile left ">

      <ul class="my-account border-bottom py-4">
        <li class=" w-100">
          <a class="button-left"><i class="fa fa-bars"></i> <span class="nav-label text-bold">Mi cuenta</span></a>
        </li>
      </ul>
      {{--################# MENU #################--}}
      <x-iprofile::user-menu layout="user-menu-layout-2" :onlyShowInTheDropdownHeader="false"
                             :onlyShowInTheMenuOfTheIndexProfilePage="true"/>

      <!--DESCOMENTAR ESTA SECCION PARA VER OTRAS FORMAS CÖMO EXTENDER EL MENU
      SOBRETODO PARA SUBMENUS -->
      <!--
      <ul class="list-sidebar">
        <li><a href="#" data-toggle="collapse" data-target="#dashboard" class="collapsed active"> <i
              class="fa fa-th-large"></i> <span class="nav-label"> Dashboards </span> <span
              class="fa fa-chevron-right pull-right"></span> </a>
          <ul class="sub-menu collapse" id="dashboard">
            <li class="active"><a href="#">CSS3 Animation</a></li>
            <li><a href="#">General</a></li>
            <li><a href="#">Buttons</a></li>
            <li><a href="#">Tabs & Accordions</a></li>
            <li><a href="#">Typography</a></li>
            <li><a href="#">FontAwesome</a></li>
            <li><a href="#">Slider</a></li>
            <li><a href="#">Panels</a></li>
            <li><a href="#">Widgets</a></li>
            <li><a href="#">Bootstrap Model</a></li>
          </ul>
        </li>
        <li><a href="#"><i class="fa fa-diamond"></i> <span class="nav-label">Layouts</span></a></li>
        <li><a href="#" data-toggle="collapse" data-target="#products" class="collapsed active"> <i
              class="fa fa-bar-chart-o"></i> <span class="nav-label">Graphs</span> <span
              class="fa fa-chevron-right pull-right"></span> </a>
          <ul class="sub-menu collapse" id="products">
            <li class="active"><a href="#">CSS3 Animation</a></li>
            <li><a href="#">General</a></li>
            <li><a href="#">Buttons</a></li>
            <li><a href="#">Tabs & Accordions</a></li>
            <li><a href="#">Typography</a></li>
            <li><a href="#">FontAwesome</a></li>
            <li><a href="#">Slider</a></li>
            <li><a href="#">Panels</a></li>
            <li><a href="#">Widgets</a></li>
            <li><a href="#">Bootstrap Model</a></li>
          </ul>
        </li>
        <li><a href="#"><i class="fa fa-laptop"></i> <span class="nav-label">Grid options</span></a></li>
        <li><a href="#" data-toggle="collapse" data-target="#tables" class="collapsed active"><i
              class="fa fa-table"></i> <span class="nav-label">Tables</span><span
              class="fa fa-chevron-right pull-right"></span></a>
          <ul class="sub-menu collapse" id="tables">
            <li><a href=""> Static Tables</a></li>
            <li><a href=""> Data Tables</a></li>
            <li><a href=""> Foo Tables</a></li>
            <li><a href=""> jqGrid</a></li>
          </ul>
        </li>
        <li><a href="#" data-toggle="collapse" data-target="#e-commerce" class="collapsed active"><i
              class="fa fa-shopping-cart"></i> <span class="nav-label">E-commerce</span><span
              class="fa fa-chevron-right pull-right"></span></a>
          <ul class="sub-menu collapse" id="e-commerce">
            <li><a href=""> Products grid</a></li>
            <li><a href=""> Products list</a></li>
            <li><a href="">Product edit</a></li>
            <li><a href=""> Product detail</a></li>
            <li><a href="">Cart</a></li>
            <li><a href=""> Orders</a></li>
            <li><a href=""> Credit Card form</a></li>
          </ul>
        </li>
        <li><a href=""><i class="fa fa-pie-chart"></i> <span class="nav-label">Metrics</span> </a></li>
        <li><a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">Other Pages</span></a></li>
        <li><a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">Other Pages</span></a></li>
        <li><a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">Other Pages</span></a></li>
        <li><a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">Other Pages</span></a></li>
        <li><a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">Other Pages</span></a></li>
      </ul>

      -->
    </div>


    <div class="container">
      <div class="row">


        <div id="profileContent" class="profile-content col-12 mb-5">
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
  @yield('profileExtraFooter')
@endsection

@section('scripts')
  @parent
  <script>
    $(document).ready(function () {
      $('.button-left').click(function () {
        var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;

        if (width <= 1620) {
          $('.sidebar-profile').toggleClass('fliph');

          if (!$('.sidebar-profile').hasClass('fliph')) {
            $('.overlay').addClass('active');
          } else {
            $('.overlay').removeClass('active');
          }

        }

      });

      var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;

      function toggleProfileMenu() {

        var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        if (width <= 1620) {
          $('.sidebar-profile').addClass('fliph');

        } else {
          $('.sidebar-profile').removeClass('fliph');

          if ($('.overlay').hasClass('active')) {
            $('.overlay').removeClass('active');
          }

        }

      }

      $(window).resize(toggleProfileMenu);
      if (width <= 1620) {
        $('.sidebar-profile').addClass('fliph');
      }
    });
  </script>
@stop
