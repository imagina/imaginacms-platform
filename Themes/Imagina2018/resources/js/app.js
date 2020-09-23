/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import axios from 'axios';
import toastr from 'toastr';

require('./bootstrap');

window.Vue = require('vue');
window.owlCarousel = require('owl.carousel');
window.VueCarousel = require('vue-carousel');
window.bus = new Vue();
window.toastr = require('toastr');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/Example.vue'));
Vue.component('categories', require('./components/Categories.vue'));
Vue.component('featurednew', require('./components/FeaturedNew.vue'));
Vue.component('bestsellers', require('./components/BestSellers.vue'));
Vue.component('featured', require('./components/Featured.vue'));

Vue.component('product', require('./components/products/product.vue'));
Vue.component('category', require('./components/products/category.vue'));
Vue.component('category-dropdown', require('./components/products/category-dropdown.vue'));
Vue.component('search', require('./components/widgets/searcher.vue'));
Vue.component('carousel-relacionados', require('./components/products/carousel-relacionados.vue'));
Vue.component('carousel-products-destacados', require('./components/BestSellers.vue'));


Vue.directive('carousel', {
    // When the bound element is inserted into the DOM...
    inserted: function (el, binding) {
        $(el).owlCarousel({
            loop: true,
            margin: 30,
            dots: false,
            nav: false,
            responsiveClass: true,
            autoplay: true,
            autoplayHoverPause: true,


            responsive: {
                0: {
                    items: 1,

                },
                768: {
                    items: 3,

                },
                1024: {
                    items: 4,
                },
            }
        });
        $('.customNextBtn1').click(function () {
            $(el).trigger('next.owl.carousel');
        });

        $('.customPrevBtn1').click(function () {
            $(el).trigger('prev.owl.carousel', [300]);
        });


    }
});
// const app = new Vue({
// el: '#app'

// });