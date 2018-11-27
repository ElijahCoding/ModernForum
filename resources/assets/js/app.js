
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

Vue.component('thread-view', require('./pages/Thread.vue'));
Vue.component('paginator', require('./components/Paginator.vue'));

const app = new Vue({
    el: '#app'
});
