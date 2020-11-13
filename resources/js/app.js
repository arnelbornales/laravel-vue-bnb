/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import router from "./routes";
import VueRouter from "vue-router";
import Vuex from 'vuex';
import Index from "./Index";
import { valHooks } from "jquery";
import moment from "moment";
import StarRating from "./shared/components/StarRating";
import Success from "./shared/components/Success";
import FatalError from "./shared/components/FatalError";
import ValidationErrors from "./shared/components/ValidationErrors";
import StoreDefinition from "./store";

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('second-component', require('./components/Example2.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(VueRouter);
Vue.use(Vuex);

Vue.filter("fromNow", value => moment(value).fromNow());

Vue.component("star-rating",StarRating); // call this <star-rating></star-rating>
Vue.component("FatalError",FatalError); // call this <FatalError></FatalError>
Vue.component("Success",Success); // call this <Success></Success>
Vue.component("v-errors",ValidationErrors); // call this <"v-errors></"v-errors>

const store = new Vuex.Store(StoreDefinition);

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        "index": Index
    },
    beforeCreate() {
        this.$store.dispatch("loadStoredState");
    },
});
