import Vue from 'vue'
import { sync } from 'vuex-router-sync'

import App from './views/App.vue'

import store from './store'
import router from './router'
import filers from './helpers/filter'

sync(store, router)

const app = new Vue({
    el: '#root',
    template: '<app></app>',
    components: { App },
    router,
    store
})