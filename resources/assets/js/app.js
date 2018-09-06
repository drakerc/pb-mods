
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Category from './components/Category';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


// Vue.component('secret-tree-view', require('./components/SecretTreeView'));
// Vue.component('secret-tree-view-item', require('./components/SecretTreeViewItem'));

const app = new Vue({
    el: '#app',
    render: h => h(Category)
});
