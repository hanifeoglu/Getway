/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import App from './paycard/src/App.vue'

Vue.config.productionTip = false

const app = new Vue({
    render: h => h(App)
}).$mount('#app')
