import 'alpinejs';
import { Model } from "vue-api-query";
import Vue from "vue";
import axios from 'axios';


window.Vue = Vue;
window.$ = window.jQuery = require('jquery');



// Boilerplate
<<<<<<< HEAD
// require('../plugins');
require('bootstrap');
=======
require('../plugins');
>>>>>>> master
require('../bootstrap');

Model.$http = axios;
Vue.prototype.moment = window.moment;

<<<<<<< HEAD
=======
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//import App from './App.vue'

>>>>>>> master
const files = require.context("./", true, /\.vue$/i);
files.keys().map(key =>
    Vue.component(
        key
            .split("/")
            .pop()
            .split(".")[0],
        files(key).default
    )
);




Vue.component(
    "paginated-table",
    require("../global/components/PaginatedTable.vue").default
);

Vue.component("pagination", require("laravel-vue-pagination"));




const app = new Vue({
<<<<<<< HEAD
    el: "#app"
=======
    // vuetify: vuetify,
    el: "#app",
>>>>>>> master
});

