<!-- vista de productos -->
<div v-if="articles.length >= 1" class="row products-index">

   <product class="col-12 col-md-4 py-2" index="true" v-for="(product, index) in articles" :key="index" comprar="true" :item="product" >
	

</div>




<!-- si no hay productos -->
<div v-else="articles.length >= 1">
    No hay productos en esta categoría ...
</div>
