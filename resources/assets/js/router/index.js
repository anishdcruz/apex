import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        { path: '/clients', component: require('../views/clients/index.vue')},
        { path: '/clients/:id/edit', component: require('../views/clients/form.vue'), meta: {mode: 'edit'}},
        { path: '/clients/:id', component: require('../views/clients/show.vue')},
        { path: '/products', component: require('../views/products/index.vue')}
    ]
})

export default router