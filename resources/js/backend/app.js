import 'alpinejs';
import { Model } from "vue-api-query";
import Vue from "vue";
import Element from 'element-ui'
// import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Element)
// import axios from 'axios';
//import App from './App.vue';
//Vue.use(Vuetify)

window.Vue = Vue;
window.$ = window.jQuery = require('jquery');

// Boilerplate
require('../plugins');
require('../bootstrap');
require('alpinejs');

Model.$http = axios;
//Vue.prototype.moment = window.moment;

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
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
    //vuetify: vuetify,
    el: "#app",

});
