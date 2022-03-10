import Vue from 'vue'
import VueRouter from 'vue-router'
import { setStatus } from '../api'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        { path: '/clients', component: require('../views/clients/index.vue').default},
        { path: '/clients/create', component: require('../views/clients/form.vue').default},
        { path: '/clients/:id/edit', component: require('../views/clients/form.vue').default, meta: {mode: 'edit'}},
        { path: '/clients/:id', component: require('../views/clients/show.vue').default},

        { path: '/products', component: require('../views/products/index.vue').default},
        { path: '/products/create', component: require('../views/products/form.vue').default},
        { path: '/products/:id/edit', component: require('../views/products/form.vue').default, meta: {mode: 'edit'}},
        { path: '/products/:id', component: require('../views/products/show.vue').default},

        { path: '/quotations', component: require('../views/quotations/index.vue').default},
        { path: '/quotations/create', component: require('../views/quotations/form.vue').default},
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
        { path: '/quotations/:id/clone', component: require('../views/quotations/form.vue').default, meta: {mode: 'clone'}},
        // convert to sales order
        { path: '/quotations/:id/sales-order', component: require('../views/sales-orders/form.vue').default, meta: {mode: 'sales-order'}},
        // convert to invoice
        { path: '/quotations/:id/invoice', component: require('../views/invoices/form.vue').default, meta: {mode: 'invoice'}},
        { path: '/quotations/:id/edit', component: require('../views/quotations/form.vue').default, meta: {mode: 'edit'}},
        { path: '/quotations/:id', component: require('../views/quotations/show.vue').default},

        { path: '/sales-orders', component: require('../views/sales-orders/index.vue').default},
        { path: '/sales-orders/create', component: require('../views/sales-orders/form.vue').default},
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
        { path: '/sales-orders/:id/edit', component: require('../views/sales-orders/form.vue').default, meta: {mode: 'edit'}},
        { path: '/sales-orders/:id/delivery', component: require('../views/deliveries/form.vue').default},
        { path: '/sales-orders/:id/invoice', component: require('../views/invoices/form.vue').default, meta: {mode: 'sales-order'}},
        { path: '/sales-orders/:id', component: require('../views/sales-orders/show.vue').default},

        { path: '/invoices', component: require('../views/invoices/index.vue').default},
        { path: '/invoices/create', component: require('../views/invoices/form.vue').default},
        // clone quotation
        { path: '/invoices/:id/clone', component: require('../views/invoices/form.vue').default, meta: {mode: 'clone'}},
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
        { path: '/invoices/:id/edit', component: require('../views/invoices/form.vue').default, meta: {mode: 'edit'}},
        { path: '/invoices/:id', component: require('../views/invoices/show.vue').default},

        { path: '/received-payments', component: require('../views/received-payments/index.vue').default},
        { path: '/received-payments/create', component: require('../views/received-payments/form.vue').default},
        { path: '/received-payments/:id', component: require('../views/received-payments/show.vue').default},

        { path: '/deliveries', component: require('../views/deliveries/index.vue').default},
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
        { path: '/deliveries/:id', component: require('../views/deliveries/show.vue').default},

        { path: '/statements', component: require('../views/statements/index.vue').default},
        { path: '/statements/create', component: require('../views/statements/form.vue').default},
        { path: '/statements/:id', component: require('../views/statements/show.vue').default},

        { path: '/settings', component: require('../views/settings/index.vue').default},

        { path: '/vendors', component: require('../views/vendors/index.vue').default},
        { path: '/vendors/create', component: require('../views/vendors/form.vue').default},
        { path: '/vendors/:id/edit', component: require('../views/vendors/form.vue').default, meta: {mode: 'edit'}},
        { path: '/vendors/:id', component: require('../views/vendors/show.vue').default},

        { path: '/purchase-orders', component: require('../views/purchase-orders/index.vue').default},
        { path: '/purchase-orders/:id/bill', component: require('../views/bills/form.vue').default, meta: {mode: 'bill'}},
        { path: '/purchase-orders/:id', component: require('../views/purchase-orders/show.vue').default},

        { path: '/expenses', component: require('../views/expenses/index.vue').default},
        { path: '/expenses/create', component: require('../views/expenses/form.vue').default},
        { path: '/expenses/:id', component: require('../views/expenses/show.vue').default},

        { path: '/bills', component: require('../views/bills/index.vue').default},
        { path: '/bills/create', component: require('../views/bills/form.vue').default},
        { path: '/bills/:id', component: require('../views/bills/show.vue').default},

        { path: '/', component: require('../views/dashboard.vue').default},
    ]
})

export default router