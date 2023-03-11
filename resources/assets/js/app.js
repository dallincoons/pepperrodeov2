
/*
 |--------------------------------------------------------------------------
 | Laravel Spark Bootstrap
 |--------------------------------------------------------------------------
 |
 | First, we will load all of the "core" dependencies for Spark which are
 | libraries such as Vue and jQuery. This also loads the Spark helpers
 | for things such as HTTP calls, forms, and form validation errors.
 |
 | Next, we'll create the root Vue application for Spark. This will start
 | the entire application and attach it to the DOM. Of course, you may
 | customize this script as you desire and load your own components.
 |
 */

require('../../../spark/resources/assets/js/spark-bootstrap');

require('./components/bootstrap');

import routes from './routes';

import DeviceNav from './components/DeviceNav.vue';

import LoginAndRegister from './components/LoginAndRegister.vue';

import VueRouter from 'vue-router';

import vueDebounce from 'vue-debounce'

Vue.use(VueRouter);
Vue.use(vueDebounce);

let router = new VueRouter({
    routes
});

window.EventBus = new Vue();

var app = new Vue({
    components : {
        DeviceNav,
        LoginAndRegister
    },

    mixins: [require('../../../spark/resources/assets/js/spark')],

    router : router
});
