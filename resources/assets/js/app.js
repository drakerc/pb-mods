/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');

import { router } from './router';
import App from './components/App';
import BootstrapVue from 'bootstrap-vue';
import axios from 'axios';
import VueYouTubeEmbed from 'vue-youtube-embed';
import { library } from '@fortawesome/fontawesome-svg-core';
import {faDownload, faCodeBranch, faListOl, faListAlt, faPlus, faBook, faFileDownload, faEdit, faTrash,
    faFont, faCamera, faVideo, faNewspaper, faStar, faFile, faCogs, faMinus, faClock, faUser, faSearch, faSave, faGamepad,
    faDoorClosed, faDoorOpen, faKey, faAngleUp, faAngleDown, faEnvelope, faDesktop, faHandsHelping } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import AsyncComputed from 'vue-async-computed';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';


library.add(faDownload, faCodeBranch, faListOl, faListAlt, faPlus, faBook, faFileDownload, faClock, faEdit,
    faSearch, faTrash, faFont, faCamera, faVideo, faNewspaper, faStar, faFile, faCogs, faUser, faSave, faMinus, faGamepad,
    faDoorClosed, faDoorOpen, faKey, faAngleUp, faAngleDown, faEnvelope, faDesktop, faHandsHelping);

Vue.component('font-awesome-icon', FontAwesomeIcon);

Vue.use(BootstrapVue);
Vue.use(require('vue-truncate-filter'));
Vue.use(VueYouTubeEmbed);
Vue.use(AsyncComputed);

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

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

axios.interceptors.response.use((response) => { // intercept the global error
    return response
}, function (error) {
    if (error.response.status === 401) {
        router.push({name: 'login'}) // if user is not logged in, redirect him to login page
    }
    if (error.response.status === 403) {
        alert(error.response.data.message);
    }

    return Promise.reject(error)
});