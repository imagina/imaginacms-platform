

<template>

  <div class="card-product shadow-product">
    <div class="bg-img">
      <a v-bind:href="item.url">
        <img
          v-bind:title="item.name"
          v-bind:alt="item.name"
          v-bind:src="item.mainImage.path"
        >
      </a>
    </div>
    <div class="mt-3 pb-3 text-center">
      <a
        v-bind:href="item.url"
        class="name cursor-pointer"
      >
        {{ item.name }}
      </a>
      <div
        class="price mt-3"
        v-if="item.price!=0.00"
      >
        {{ currencysymbolleft }}{{ item.formattedPrice }}
      </div>
      <a class="cart-no">&nbsp;</a>
      <div
        class="pointer-product-new actions-product "
        v-if="item.price!=0.00"
      >
        <a
          v-bind:href="item.url"
          class=" d-none mx-1 padding-icons-product-new rounded icon-actions"
        >
          <i class="fa fa-search"></i>
        </a>
        <a
          v-if="item.price!=0.00"
          v-on:click="addCart(item)"
          v-show="item.price > 0"
          class="cart text-black cursor-pointer change-color-buttom-comprar text-white bg-secondary rounded margin-button-product-new button-comprar show"
        >

          <span class="">
            <i class="fa fa-shopping-cart"></i>
            COMPRAR
          </span>
        </a>
        <a
          href="/contacto"
          v-else
          class="cart text-black cursor-pointer change-color-buttom-comprar text-white bg-secondary rounded margin-button-product-new button-comprar show"
        >
          <span class="">

            CONSULTAR
          </span>

        </a>
        <a
          @click="addWishList(item)"
          class="padding-icons-product-new rounded icon-actions mx-2 d-none"
        >
          <i class=" fa fa-heart-o "></i>
        </a>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: [
    'item', 'index', 'comprar'
  ],
  data() {
    return {

      loading: true,
      carousel: false,
      quantity: 1,
      currencysymbolleft: icommerce.currencySymbolLeft,
      currencysymbolright: icommerce.currencySymbolRight,

    }
  },
  filters: {
    numberFormat: function (value) {
      return parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1.').slice(0, -3);;
    }
  },


  methods: {
    addCart: function (item) {
      vue_carting.addItemCart(item.id, item.name, item.price);
    },
    addWishList: function (item) {
      vue_carting.addWishList(item);
    },
  },
}
</script>
