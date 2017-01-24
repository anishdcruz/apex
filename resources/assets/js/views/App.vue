<template>
    <div id="root" class="root">
        <div class="sidebar">
            <div v-for="(group, index) in groups" class="sidebar-group">
                <strong class="sidebar-title">{{group.title}}</strong>
                <ul v-for="item in group.links" class="sidebar-links">
                    <li class="sidebar-item">
                        <router-link :to="item.path" class="sidebar-link">
                            <i :class="['fa', 'sidebar-icon',item.icon]"></i>
                            <span class="sidebar-text">{{item.title}}</span>
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content">
            <div class="navbar">
                ok!
            </div>
            <router-view v-show="notLoading"></router-view>
        </div>
    </div>
</template>
<script type="text/javascript">
    export default {
        data() {
            return {
                groups: [
                    {
                        title: 'Sales',
                        links: [
                            { title: 'Clients', path: '/clients', icon: 'fa-address-book' },
                            { title: 'Quotation', path: '/quotations', icon: 'fa-file-text-o' },
                            { title: 'Sales Order', path: '/sales-orders', icon: 'fa-file-text-o' },
                            { title: 'Invoice', path: '/invoice', icon: 'fa-file-text-o' },
                            { title: 'Payment Received', path: '/payment-received', icon: 'fa-money' }
                        ]
                    },
                    {
                        title: 'Inventory',
                        links: [
                            { title: 'Products', path: '/products', icon: 'fa-laptop' },
                            { title: 'Receive', path: '/receive', icon: 'fa-cubes' },
                            { title: 'Delivery', path: '/delivery', icon: 'fa-truck' }
                        ]
                    },
                    {
                        title: 'Purchase',
                        links: [
                            { title: 'Vendors', path: '/vendors', icon: 'fa-users' },
                            { title: 'Expenses', path: '/expenses', icon: 'fa-credit-card' },
                            { title: 'Purchase Order', path: '/purchase-order', icon: 'fa-file-text-o' },
                            { title: 'Bill', path: '/bill', icon: 'fa-file-text' },
                            { title: 'Payment Made', path: '/payment-made', icon: 'fa-money' }
                        ]
                    },
                    {
                        title: 'Accounting',
                        links: [
                            { title: 'Statement of Account', path: '/statement-of-account', icon: 'fa-file-excel-o' },
                            { title: 'Balance Sheet', path: '/balance-sheet', icon: 'fa-file-text-o' }
                        ]
                    },
                    {
                        title: 'Work',
                        links: [
                            { title: 'Projects', path: '/expenses', icon: 'fa-building' },
                            { title: 'Issues', path: '/issues', icon: 'fa-cogs' },
                            { title: 'AMC', path: '/amc', icon: 'fa-handshake-o' }
                        ]
                    },
                ]
            }
        },
        computed: {
            notLoading() {
                return !this.$store.state.loading
            }
        }
    }
</script>