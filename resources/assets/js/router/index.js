import Vue from 'vue'
import VueRouter from 'vue-router'
import { setStatus } from '../api'

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
        // change status of quotation
        { path: '/quotations/:id/status/:type', beforeEnter: function(to, from, next) {
            setStatus(`quotations/${to.params.id}/status/${to.params.type}`, function(data) {
                if(data.saved) {
                    next(`/quotations/${to.params.id}?saved=${to.params.type}`)
                }
            }, function(error) {
                next(`/quotations/${to.params.id}?error=${to.params.type}`)
            })
        }},
        // clone quotation
        { path: '/quotations/:id/clone', component: require('../views/quotations/form.vue'), meta: {mode: 'clone'}},
        // convert to sales order
        { path: '/quotations/:id/sales-order', component: require('../views/sales-orders/form.vue'), meta: {mode: 'sales-order'}},
        // convert to invoice
        { path: '/quotations/:id/invoice', component: require('../views/invoices/form.vue'), meta: {mode: 'invoice'}},
        { path: '/quotations/:id/edit', component: require('../views/quotations/form.vue'), meta: {mode: 'edit'}},
        { path: '/quotations/:id', component: require('../views/quotations/show.vue')},

        { path: '/sales-orders', component: require('../views/sales-orders/index.vue')},
        { path: '/sales-orders/create', component: require('../views/sales-orders/form.vue')},
        // change status of quotation
        { path: '/sales-orders/:id/status/:type', beforeEnter: function(to, from, next) {
            setStatus(`sales_orders/${to.params.id}/status/${to.params.type}`, function(data) {
                if(data.saved) {
                    next(`/sales-orders/${to.params.id}?saved=${to.params.type}`)
                }
            }, function(error) {
                next(`/sales-orders/${to.params.id}?error=${to.params.type}`)
            })
        }},
        { path: '/sales-orders/:id/edit', component: require('../views/sales-orders/form.vue'), meta: {mode: 'edit'}},
        { path: '/sales-orders/:id/delivery', component: require('../views/deliveries/form.vue')},
        { path: '/sales-orders/:id/invoice', component: require('../views/invoices/form.vue'), meta: {mode: 'sales-order'}},
        { path: '/sales-orders/:id', component: require('../views/sales-orders/show.vue')},

        { path: '/invoices', component: require('../views/invoices/index.vue')},
        { path: '/invoices/create', component: require('../views/invoices/form.vue')},
        // clone quotation
        { path: '/invoices/:id/clone', component: require('../views/invoices/form.vue'), meta: {mode: 'clone'}},
        // change status of quotation
        { path: '/invoices/:id/status/:type', beforeEnter: function(to, from, next) {
            setStatus(`invoices/${to.params.id}/status/${to.params.type}`, function(data) {
                if(data.saved) {
                    next(`/invoices/${to.params.id}?saved=${to.params.type}`)
                }
            }, function(error) {
                next(`/invoices/${to.params.id}?error=${to.params.type}`)
            })
        }},
        { path: '/invoices/:id/edit', component: require('../views/invoices/form.vue'), meta: {mode: 'edit'}},
        { path: '/invoices/:id', component: require('../views/invoices/show.vue')},

        { path: '/received-payments', component: require('../views/received-payments/index.vue')},
        { path: '/received-payments/create', component: require('../views/received-payments/form.vue')},
        { path: '/received-payments/:id', component: require('../views/received-payments/show.vue')},

        { path: '/deliveries', component: require('../views/deliveries/index.vue')},
        // change status of quotation
        { path: '/deliveries/:id/status/:type', beforeEnter: function(to, from, next) {
            setStatus(`deliveries/${to.params.id}/status/${to.params.type}`, function(data) {
                if(data.saved) {
                    next(`/deliveries/${to.params.id}?saved=${to.params.type}`)
                }
            }, function(error) {
                next(`/deliveries/${to.params.id}?error=${to.params.type}`)
            })
        }},
        { path: '/deliveries/:id', component: require('../views/deliveries/show.vue')}
    ]
})

export default router