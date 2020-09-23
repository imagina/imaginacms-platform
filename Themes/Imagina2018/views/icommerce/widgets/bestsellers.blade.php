<section id="bestsellers" class="actions-bestsellers iblock pb-5" data-blocksrc="general.block14">
    <div class="container">
        <div class="row">
            <div class="container col-12">
                <div >
                    <h2 class="">
                        Los más Vendidos</h2>
                </div>
                <br>
                <nav>
                    
                    <ul class="nav nav-tabs justify-content-center justify-content-md-start" id="myTab" role="tablist">
                        <li class="nav-item" v-for="(category,index) in categories" v-if="category.id!=14 && category.id!=13"                           :key="'categoryTab'+category.id">
                        <a 
                        
                           :class="'nav-link border-0 '+(index == 0 ? 'active' : '')"
                           :id="'nav-'+category.slug+'-tab'"
                           data-toggle="tab"
                           :href="'#nav'+category.slug"
                           role="tab"
                           :aria-controls="'nav-'+category.slug"
                           :aria-selected="index==0 ? true : false">
                            @{{category.title}}
                        </a>
                        </li>
                        <li class="nav-item ml-auto">                        
                            <div class="nav justify-content-center justify-content-md-between">
                                <a class="customPrevBtn" href="#demo" data-slide="prev">
                                    <span class=" fa fa-chevron-left "></span>
                                </a>
                                <a class="customNextBtn" href="#demo" data-slide="next">
                                    <span class=" fa fa-chevron-right "></span>
                                </a>
                            </div>
                        </li>
                    </div>

                </nav>
                <div class="tab-content" id="nav-tabContent">
                    
                    <div v-for="(category,index) in categories" :key="'category'+category.id" :class="'tab-pane fade '+ (index == 0 ? 'show active' : '' )"
                         :id="'nav'+category.slug" role="tabpanel"
                         v-if="category.id!=14 && category.id!=13"
                         :aria-labelledby="'nav-'+category-slug+'-tab'">
                    
                        
                        <div id="demo" class="carousel slide" data-ride="carousel">
                        
                            <div class="carousel-inner">
                        
                                <div class="carousel-item active">
                                    <bestsellers @add-cart="addCart" :take="8"
                                                 :categories="[category.id]"></bestsellers>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</section>


@section('scripts-owl')
    @parent

    <script>
        const bestsellers = new Vue({
            el: '#bestsellers',
            data: {
                currency: false,
                products_bestsellers: [],
                user: false,
                categories: [],
                loading: true,
            },
            mounted: function () {
                this.$nextTick(function () {
                    this.getCategories();
                });
            },
            methods: {
                /*agrega el producto al carro de compras*/
                addCart: function (item) {
                    vue_carting.addItemCart(item.id, item.name, item.price);
                },

                getCategories: function () {
                    let uri = icommerce.url + '/api/icommerce/v3/categories?filter={"status":1,"parentId":0}&take=' + this.take;
                    axios.get(uri, {params: {}})
                        .then(response => {
                            this.categories = response.data.data;
                        })
                        .catch(error => {
                            console.log(error)
                        })
                        .finally(() => this.loading = false
                        )

                }
            }
        });
    </script>
@stop
