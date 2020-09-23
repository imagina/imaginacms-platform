{{-- 
<div class="filter-price col-md-3 col-6">
    <h3 class="text-capitalize">{{trans('icommerce::common.range.title')}}</h3>
    <div class="d-inline-block">
        <a class="cursor-pointer d-block w-100" @click="filter_price([min_price,150])"> $0.00 - $150.00</a>
        <a class="cursor-pointer d-block w-100" @click="filter_price([150,300])">$150.00 - $300.00</a>
        <a class="cursor-pointer d-block w-100" @click="filter_price([300,450])">$300.00 - $450.00</a>
        <a class="cursor-pointer d-block w-100" @click="filter_price([450,max_price])">$450.00 +</a>
    </div>
</div> --}}

<div class="card card-items mb-3 precio">
    <div class="card-header">
    	<a class="d-flex  align-items-center justify-content-between w-100 "  data-toggle="collapse" href="#collapse-precio" role="button" aria-expanded="true"  aria-controls="collapse-precio">
        Precio <i class="fa fa-angle-down"></i>
    	</a>
    </div>

    <div class="range_price_content card-body px-0" id="collapse-precio" class="sub-categoria collapse show" aria-labelledby="collapse-precio" >
        <!-- valores -->        
        <div class="ran-val d-flex justify-content-between mt-0 mb-2">
            <span id="min2">
            </span>
            <span id="max2">
            </span>
        </div>
        <!-- rango -->
        <div id="slider-range" @blur="getProducts()"></div>
        <!-- valores -->        
       	<div class="ran-val">
          	<p id="min">
        	</p>
        	<p>-</p>
           	<p id="max">
            </p>
        </div>
  </div>
</div>