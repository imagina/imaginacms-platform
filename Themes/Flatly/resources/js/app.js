/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.toastr = require('toastr');
window.axios = require('axios');
window.VueCarousel = require('vue-carousel');
window.Vuelidate = require('vuelidate');
window.validators = require('vuelidate/lib/validators');
window.Vue.use(window.Vuelidate.default)

import Vue from 'vue';
import axios from 'axios';
import toastr from 'toastr';
import 'lazysizes';
import 'lazysizes/plugins/parent-fit/ls.parent-fit';
window.bus = new Vue();

//sweetalert2 for livewire alerts
// CommonJS
window.Swal = require('sweetalert2')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/* TODO: Move widgets to modules
Vue.component('categories', require('./components/Categories.vue'));
Vue.component('featurednew', require('./components/FeaturedNew.vue'));
Vue.component('bestsellers', require('./components/BestSellers.vue'));
Vue.component('featured', require('./components/Featured.vue'));
*/

/*
const app = new Vue({
    el: '#app'

});
*/
