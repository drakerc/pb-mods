
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import router from './router';
import App from './components/App';
import BootstrapVue from 'bootstrap-vue';
import axios from 'axios';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
    render: h => h(App),
    router
});

Vue.use(BootstrapVue);
Vue.use(require('vue-truncate-filter'));

axios.interceptors.response.use((response) => { // intercept the global error
    return response
}, function (error) {
    if (error.response.status === 401) {
        router.push({name: 'login'}) // if user is not logged in, redirect him to login page
    }
    return Promise.reject(error)
});