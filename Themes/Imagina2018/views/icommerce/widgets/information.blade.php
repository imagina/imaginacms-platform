<h2 class="w-100 text-center text-md-left title "><strong>@{{product.name}}</strong></h2>

<div class="d-md-flex">
  <p class="price mb-3 mb-md-0" v-if="product.price >0.00"> <strong> @{{currencysymbolleft}} @{{ product.price | numberFormat }} @{{currencysymbolright}}</strong></p>
  <p v-else class="price"><strong> No Disponible...</strong></p>  
</div>
<div class="summary"  v-html="product.summary"></div>

<!-- OPCIONES DE PRODUCTO -->
@include('icommerce.widgets.opciones-producto')
<hr>
<div class="d-flex flex-wrap justify-content-center justify-content-md-between pb-3">
    <div class="d-flex flex-wrap align-items-center" v-if="product.price > 0.00">
        <div class="number-input" >
              <div class="input-group-prepend">
                  <button class="text-center "
                          type="button"
                          field="quantity"
                          v-on:click="quantity >= 2 ? quantity-- : false">
                      <i class="fa fa-minus"></i>
                  </button>
              </div>
              <input type="text"
                     class="form-control text-center"
                     name="quantity"
                     v-model="quantity"
                     aria-label=""
                     aria-describedby="basic-addon1">
              <div class="input-group-append">
                  <button class="text-center "
                          type="button"
                          field="quantity"
                          v-on:click="quantity < product.quantity ? quantity++ : false">
                     <i class="fa fa-plus"></i>
                  </button>
              </div>
      </div>
    </div>
  <button  v-on:click="addCart(product)"   class="add add-secondary" v-if="product.price >0.00">COMPRAR</button>
  <button href="{{ url('/contacto') }}" class="add add-secondary" v-else>Consultar</button>
  <button v-on:click="addWishList(product)" class="add add-primary " ><i class="fa fa-heart-o"></i></button>                
</div>    


<hr>
<a href="{{url('contacto')}}">¿Tiene más preguntas sobre este artículo?</a>
<hr>

<div class="social">
    <span>Comparte en  :</span>
      <a href="javascript::;" onclick="window.open('http://www.facebook.com/sharer.php?u={{$product->url}}','Facebook','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+'')" title="Facebook" rel="nofollow" class="facebook"><i class="fa fa-facebook"></i></a>
      <a href="javascript::;" onclick="window.open('http://twitter.com/share?url={{$product->url}}','Twitter share','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+'')" title="Twitter" rel="nofollow" class="twitter"><i class="fa fa-twitter"></i></a>
      <a href="#" target="_blank">
          <i class="fa fa-whatsapp"></i>
      </a>
  </div>

  <hr>