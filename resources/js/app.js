/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

import Vue from 'vue'
import VueRouter from 'vue-router'
import VueAWN from 'vue-awesome-notifications'
import AsyncComputed from 'vue-async-computed'
import router from './router'
import store from './store'

window.Vue = require('vue').default
Vue.use(VueRouter)

let awnOptions = {
    position: "top-right",
    labels: {
        confirm: ''
    },
    durations: {
        global: 3000
    },
    icons: {
        prefix: "<span style='font-size: 2.5em;' class='material-icons-outlined'>",
        info: "info",
        success: "check_circle",
        alert: "highlight_off",
        warning: "report_problem",
        confirm: "report_problem",
        suffix: "</span>"
    }
}
Vue.use(VueAWN, awnOptions)
Vue.use(AsyncComputed)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store
})
