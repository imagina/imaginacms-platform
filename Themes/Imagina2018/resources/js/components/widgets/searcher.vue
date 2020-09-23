



<template>

  <div id="search-box">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 p-0">
          <div class="search-product">

            <div
              id="content_searcher"
              class="dropdown"
            >
              <!-- input -->
              <div
                id="dropdownSearch"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                role="button"
                class="input-group dropdown-toggle"
              >
                <input
                  id="input_search"
                  placeholder="Nombre del producto"
                  class="form-control border-0"
                  type="text"
                  v-on:keyup="view_result2"
                  v-model="criterion"
                >
                <div
                  class="input-group-btn"
                  v-on:click="view_result()"
                >
                  <button
                    type="button"
                    style="margin-top: 1px; margin-right: 1px"
                    class=""
                  >
                    <span class="fa fa-search"></span>
                  </button>
                </div>
              </div>

              <!-- dropdaown search result -->
              <div
                id="display_result"
                class="dropdown-menu w-100 rounded-0 py-3 m-0 d-none"
                aria-labelledby="dropdownSearch"
                style="z-index: 999999;"
              >

                <div v-if="result && result.length > 0">
                  <div
                    class="cart-items px-3 mb-3"
                    v-for="(item,index) in result"
                    style="max-height: 70px"
                    :key="index"
                  >
                    <!--Shopping cart items -->
                    <div
                      v-if="index <= 4"
                      class="cart-items-item row"
                    >
                      <!-- image -->
                      <a
                        v-bind:href="item.url"
                        class="cart-img pr-0  float-left col-3 text-center"
                      >
                        <img
                          class="img-fluid"
                          v-bind:src="item.mainImage.path"
                          v-bind:alt="item.name"
                          style="max-height: 76px"
                        >
                      </a>
                      <!-- dates -->
                      <div class="float-left col-9">
                        <!-- title -->
                        <h6 class="mb-0">
                          <a
                            :href="item.url"
                            class="text-secondary font-weight-bold text-capitalize"
                          >
                            {{ item.name }}
                          </a>
                        </h6>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="text-right">
                    <a
                      v-bind:href="[route_view+'?search='+criterion]"
                      class="text-secondary font-weight-bold"
                    >
                      {{this.texto1}}
                    </a>
                  </div>
                </div>
                <div v-else>
                  <h6 class="text-primary text-center">
                    {{texto2}}
                  </h6>
                </div>
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
    'view',

  ],
  data() {
    return {
      result: [],
      criterion: '',
      url: icommerce.url,
      texto1: Laravel.trans.search.see_all,
      texto2: Laravel.trans.search.no_results,
      urlproducts: Laravel.router.products_index,
      route_view: this.view,
    }
  },
  methods: {
    search: function () {
      this.criterion ? this.get_products() : this.result = [];
    },
    /*obtiene los productos */
    get_products: function () {
      var filter = {
        search: this.criterion,
        status: 1,
        order: {
          field: "created_at",
          way: "DESC"
        }
      };
      axios({
        method: 'Get',
        responseType: 'json',
        url: this.urlproducts,
        params: {
          filter: filter,
          take: 8,
        }
      }).then(response => {
        this.result = response.data.data;
      });
    },
    /*evento enter sobre el buscar*/
    event_searcher: function () {
      $("#input_search").keyup(function (e) {
        var val = $(this).val();

        if (val) {
          if (e.keyCode === 13) {
            this.view_result();
          } else {
            this.search();
          }
        } else {
          this.result = []
        }
      });
    },
    /*carga la vista con todos los resultados*/
    view_result2: function () {
      if (this.criterion) {
        this.search();
        $("#display_result").removeClass("d-none");
      } else {
        $("#input_search").focus();
        $("#display_result").addClass("d-none");
      }

    },
    view_result: function () {
      if (this.criterion) {
        window.location.href = this.route_view + '?search=' + this.criterion;
      } else {
        $("#input_search").focus();
      }
    }
  },
  mounted: function () {
    this.$nextTick(function () {
      this.event_searcher();
    });
  }
}
    </script>

