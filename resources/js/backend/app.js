import 'alpinejs';
import { Model } from "vue-api-query";
import Vue from "vue";
import axios from 'axios';
import VueSweetalert2 from 'vue-sweetalert2';


window.Vue = Vue;
window.$ = window.jQuery = require('jquery');
window.Swal = require('sweetalert2');

Vue.use(VueSweetalert2);


require('../plugins');
require('../bootstrap');

Model.$http = axios;
Vue.prototype.moment = window.moment;

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

    el: "#app"

});

