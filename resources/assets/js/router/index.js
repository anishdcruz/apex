import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        { path: '/clients', component: require('../views/clients/index.vue')}
    ]
})

export default router