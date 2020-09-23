<template>
  <carousel
    :scrollPerPage="true"
    :perPage="1"
    :perPageCustom="[[0, 1], [540, 2], [768, 3], [992, 4]]"
    :autoplay="true"
    :speed="500"
    :interval="10000"
    :loop="true"
    :paginationEnabled="false"
    :navigationEnabled="true"
    navigationNextLabel="<div class='owl-icon-right'></div>"
    navigationPrevLabel="<div class='owl-icon-left'></div>"
  >
    <slide
      class="action-shadow px-3 py-5"
      v-for=" article in articles"
      v-bind:key="'featured-new-product-'+article.id"
    >
      <product
        v-if="article.price!=0.00"
        class="d-none"
        index="true"
        comprar="true"
        :item="article"
      ></product>
    </slide>
  </carousel>
</template>
<script>

export default {

  props: [
    'take'
  ],
  data() {
    return {
      articles: [],
      currencysymbolleft: icommerce.currencySymbolLeft,
      currencysymbolright: icommerce.currencySymbolRight,
      loading: true,
    }
  },
  components: {
    'carousel': VueCarousel.Carousel,
    'slide': VueCarousel.Slide
  },
  mounted: function () {
    this.$nextTick(function () {
      this.getData();
    });
  },
  methods: {
    getData: function () {
      let uri = icommerce.url + '/api/icommerce/v3/products?filter={"order":{"way":"desc","field":"created_at"},"status":1}&take=' + this.take;
      axios.get(uri, { params: { include: 'category' } })
        .then(response => {
          this.articles = response.data.data;
        })
        .catch(error => {
          console.log(error)
        })
        .finally(() => this.loading = false
        )
    }
  },
}
</script>
