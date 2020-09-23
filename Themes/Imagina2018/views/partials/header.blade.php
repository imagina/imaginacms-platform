
<header>

	<div class="header-top bg-primary">
		<div class="container-fluid">
			<div class="container">
				<div class="row justify-content-end" >
					<div  class="icontenteditable col-12 col-md-auto d-flex justify-content-center align-items-center justify-content-md-start ">
						<i class="fa fa-phone mr-2"></i> <a href="tel:3114554055 ">3114554055 </a> - <a href="tel:3112234137 "> 3112234137 </a>
					</div>
					<div class="col-12 col-md-auto d-flex justify-content-center align-items-center justify-content-md-start ">
						<i class="fa fa-envelope mr-2"></i> <a href="#">Info@pinturasrenovar.com</a>
					</div>
					<div class="col-12 col-md-auto d-flex justify-content-center align-items-center ml-md-auto">
					<span class="float-right ">
						@include('iprofile.widgets.logged')
					</span>

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="header-content bg-white"  >
		<div class="container bg-white">
			<div class="row justify-content-between align-items-center bg-white">
				<div class="col-12 col-sm-auto col-md-auto col-lg py-3 order-0 text-center">
					<a href="{{url('/')}}"><img src="{{url('/themes/imagina2018/img/logo.png')}}" class="img-fluid"/></a>
				</div>
				<div class="col-12 col-md-7 py-3 ">
					<div id="search">
                        <search view="{{url('/busqueda')}}" ></search>
                    </div>
				</div>
				<div class="col-12 col-md-auto col-lg-auto py-3 text-right d-flex align-items-center car">
					<div class="text-center"><a href="#" ><i class="fa fa-heart-o"></i></a></div>
					<div class="border-left">@include('icommerce.widgets.carting')</div>				
					<button class="navbar-toggler ml-auto d-lg-none  border-0 p-0" type="button" data-toggle="collapse" data-target="#pinturasNavbar" aria-controls="pinturasNavbar" aria-expanded="false" aria-label="Toggle navigation">
						<i class="fa fa-bars ml-0 mr-3"></i> <span class="font-weight-bold">Menu</span>
					</button>	
				</div>
			</div>
		</div>
	</div>

	<div class="header-bottom">
		<div class="container-fluid border-top border-primary bg-white">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-12 ">
						@include('partials.navigation')
					</div>
				</div>
			</div>
		</div>

	</div>
	<div class="position-fixed img-responsiven logo pulsate-fwd" style="right: 0;z-index: 99;">
		<a href="https://api.whatsapp.com/send?phone=573138546796" target="_blank"> <img src="{{url('/themes/imagina2018/img/whatapps.png')}}"  class="img-fluid" alt="whatapps"></a>
	</div>
</header>


  
@section('scripts-header')
@parent
<script>
    new Vue({ el: '#categories_dropdown' });
    new Vue({ el: '#search' });
    
    $(document).ready(function() {
      $(document).on('click', '.dropdown-menu', function (e) {
          e.stopPropagation();
      });

      // make it as accordion for smaller screens
      if ($(window).width() < 992) {
		$('.dropdown-menu li, .submenu li').click(function(e){
				$(this+"  ul").toggleClass('d-block');				
		});
          $('.dropdown-menu a').click(function(e){
              e.preventDefault();
              if($(this).next('.submenu').length){
                  $(this).next('.submenu').toggle();
              }
              $('.dropdown').on('hide.bs.dropdown', function () {
                  $(this).find('.submenu').hide();
              })
          });
      }
  });
</script>
@endsection