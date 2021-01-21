/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)
    /**
     * The following block of code may be used to automatically register your
     * Vue components. It will recursively scan this directory for the Vue
     * components and automatically register them with their "basename".
     *
     * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
     */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('user-chat', require('./components/UserChatComponent.vue').default);
Vue.component('add-to-cart-form', require('./components/AddToCartForm.vue').default);
Vue.component('product-quantity-increase', require('./components/ProductQuantityIncrease.vue').default);
Vue.component('product-quantity-decrease', require('./components/ProductQuantityDecrease.vue').default);
Vue.component('product-quantity', require('./components/ProductQuantity.vue').default);
Vue.component('paystack-payment', require('./components/paystack.vue').default);
Vue.component('flutterwave-payment', require('./components/flutterwave.vue').default);
Vue.component('admin-chat', require('./components/AdminChat.vue').default);
Vue.component('admin-message', require('./components/AdminMessage.vue').default);
Vue.component('user-list', require('./components/UsersList.vue').default);
Vue.component('drop-zone', require('./components/DropComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
export let bus = new Vue({});
const app = new Vue({
    el: '#app',
});