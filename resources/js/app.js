import 'alpinejs';
import { Model } from "vue-api-query";
import Vue from "vue";
import axios from 'axios';

require('./bootstrap');
require('./plugins');

window.Vue = require('vue').default;
window.$ = window.jQuery = require('jquery');

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
    require("./global/components/PaginatedTable.vue").default
);

Vue.component("pagination", require("laravel-vue-pagination"));

const app = new Vue({
    el: '#app',
});
