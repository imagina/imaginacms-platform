<template>
  <carousel
    :scrollPerPage="true"
    :perPage="1"
    :perPageCustom="[[0, 1], [480, 1], [768, 2], [920, 3]]"
    :autoplay="true"
    :speed="500"
    :navigationEnabled="true"
    :autoplayTimeout="5000"
    :loop="true"
    :paginationEnabled="false"
    navigationNextLabel="<i class='fa fa-chevron-right'></i>"
    navigationPrevLabel="<i class='fa fa-chevron-left'></i>"
  >
    <slide
      class="action-categories"
      v-for="category in categories"
      :key="'category-'+category.id"
    >
      <div
        class="d-flex mx-2 card card-categories text-white border-0 text-center"
        v-if="
        article.price!=0.00"
      >
        <img
          :alt="category.title"
          :src="category.mainImage.path"
        >
        <div class="card-img-overlay">
          <div class="margins-text-category">
            <h5
              class=" text-capitalize"
              id="textCategory1"
            >{{ category.title }}</h5>
          </div>
          <p>{{category.description}}</p>
          <a
            :href="category.slug"
            class=" btn link px-4 text-primary rounded bg-white "
          >
            VER MÁS
          </a>
        </div>
        <div
          class="flex-column"
          id="actionsTextCategory"
          style="background-color: rgba(249, 102, 17, 0.5);"
        >
          <h5
            class="card-title text-capitalize"
            id="textCategory2"
          >{{ category.title }}</h5>
        </div>
      </div>
    </slide>
  </carousel>
</template>

<script>
export default {
  mounted() {
    this.$nextTick(function () {
      this.getCategories();
    });
  },
  components: {
    'carousel': VueCarousel.Carousel,
    'slide': VueCarousel.Slide
  },
  data() {
    return {
      categories: [],
      loading: true
    }
  },
  methods: {
    getCategories() {
      let uri = icommerce.url + '/api/icommerce/v3/categories?filter={"parentId":0}';
      axios.get(uri)
        .then((response) => {
          this.categories = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => this.loading = false
        )
    }
  },
}
</script>