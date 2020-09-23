<template>
  <div
    class="row"
    id="actionsSliderProducts"
  >
    <div
      class="col-12 col-md-6 col-lg-4"
      v-for="article in articles"
      v-bind:key="'best-seller-product-'+article.id"
    >
      <div class="card-product-mini mb-4">
        <div class="row no-gutters align-items-center ">
          <div class="col-5">
            <a v-bind:href="article.url">
              <img
                class="card-img p-1"
                v-bind:title="article.name"
                v-bind:alt="article.name"
                v-bind:src="article.mainImage.path"
              >
            </a>
          </div>
          <div class="col-7">
            <div class="card-body p-1 text-truncate">
              <!--              <div class="category">-->
              <!--                {{ article.category.title }}-->
              <!--              </div>-->

              <a
                v-bind:href="article.url"
                v-bind:title="article.name"
                class="name text-dark font-weight-normal cursor-pointer"
              >
                {{ article.name }}
              </a>

              <div class="price mb-3 mt-3 font-weight-bold">
                {{ currencysymbolleft }}{{ article.formattedPrice }}
              </div>
              <!--              <a class="cart-no">&nbsp;</a>-->
              <div class="btn btn-secondary btn-sm">
                <i class="fa fa-shopping-cart icon text-white"></i>
                <a
                  v-if="article.price!=0.00"
                  v-on:click="$emit('add-cart',article)"
                  v-show="article.price > 0"
                  class="cart text-white cursor-pointer "
                >
                  COMPRAR
                </a>
                <a
                  href="/contacto"
                  v-else
                  class="cart text-primary cursor-pointer"
                >
                  Contacta con nosotros
                </a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: [
    'take',
    'categories'
  ],
  data() {
    return {
      articles: [],
      currencysymbolleft: icommerce.currencySymbolLeft,
      currencysymbolright: icommerce.currencySymbolRight,
      loading: true,
    }
  },
  mounted: function () {
    this.$nextTick(function () {
      this.getData();
    });
  },
  methods: {
    getData: function () {
      let uri = icommerce.url + `/api/icommerce/v3/products`;
      console.warn(uri);

      axios.get(uri, {
        params: {
          include: 'category',
          filter: {
            bestsellers: 1,
            status: 1,
            categories: this.categories
          },
          take: this.take
        }
      })
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
<div class="row">
<div class="container">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
         aria-selected="true">Home</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
         aria-selected="false">Profile</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
         aria-selected="false">Contact</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
  </div>
</div>
</div>
