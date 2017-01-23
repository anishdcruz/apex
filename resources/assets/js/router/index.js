import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        { path: '/clients', component: require('../views/clients/index.vue')},
        { path: '/clients/create', component: require('../views/clients/form.vue')},
        { path: '/clients/:id/edit', component: require('../views/clients/form.vue'), meta: {mode: 'edit'}},
        { path: '/clients/:id', component: require('../views/clients/show.vue')},

        { path: '/products', component: require('../views/products/index.vue')},
        { path: '/products/create', component: require('../views/products/form.vue')},
        { path: '/products/:id/edit', component: require('../views/products/form.vue'), meta: {mode: 'edit'}},
        { path: '/products/:id', component: require('../views/products/show.vue')},

        { path: '/quotations', component: require('../views/quotations/index.vue')},
    ]
})

export default router