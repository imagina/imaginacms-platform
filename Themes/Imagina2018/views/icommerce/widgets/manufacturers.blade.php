

<div class="card card-items mb-3 manufacturer">
    <div class="card-header">
    	<a class="d-flex  align-items-center justify-content-between w-100"  data-toggle="collapse" href="#collapse-manufacturer" role="button" aria-expanded="true"  aria-controls="collapse-manufacturer">
        Marcas <i class="fa fa-angle-down"></i>
    	</a>
    </div>

    <div class="card-body px-0" id="collapse-manufacturer" class="sub-categoria collapse show card-body" aria-labelledby="collapse-manufacturer" >
          <div  class="categoria">  
           
            <button v-for="item in manufacturers" :value="item.id">@{{ item.name }}</button>
       </div>
  </div>
</div>