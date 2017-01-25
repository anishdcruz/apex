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
        { path: '/quotations/create', component: require('../views/quotations/form.vue')},
        { path: '/quotations/:id/edit', component: require('../views/quotations/form.vue'), meta: {mode: 'edit'}},
        { path: '/quotations/:id', component: require('../views/quotations/show.vue')},

        { path: '/sales-orders', component: require('../views/sales-orders/index.vue')},
        { path: '/sales-orders/create', component: require('../views/sales-orders/form.vue')},
        { path: '/sales-orders/:id/edit', component: require('../views/sales-orders/form.vue'), meta: {mode: 'edit'}},
        { path: '/sales-orders/:id', component: require('../views/sales-orders/show.vue')},

        { path: '/invoices', component: require('../views/invoices/index.vue')},
        { path: '/invoices/create', component: require('../views/invoices/form.vue')},
        { path: '/invoices/:id/edit', component: require('../views/invoices/form.vue'), meta: {mode: 'edit'}},
        { path: '/invoices/:id', component: require('../views/invoices/show.vue')},

        { path: '/received-payments', component: require('../views/received-payments/index.vue')},
        { path: '/received-payments/create', component: require('../views/received-payments/form.vue')},
        { path: '/received-payments/:id', component: require('../views/received-payments/show.vue')},
    ]
})

export default router