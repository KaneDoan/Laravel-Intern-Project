import 'alpinejs';
import { Model } from "vue-api-query";

import Vue from "vue";
// import axios from 'axios';
//import App from './App.vue';

window.Vue = Vue;
window.$ = window.jQuery = require('jquery');

// Boilerplate
//require('../plugins');
require('../bootstrap');

Model.$http = axios;
Vue.prototype.moment = window.moment;

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
import App from './App.vue'

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

const app = new Vue({
    // vuetify: vuetify,
    el: "#app",
    data: {
        message: "testing vue"
    }
    // components: { App }
});
