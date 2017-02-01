<template>
    <div class="view">
        <index :thead="thead" :resource="resource" :filter="filter">
            <span slot="title">Purchase Order</span>
            <router-link to="/purchase-orders/create" class="btn btn-primary" slot="create">Create Purchase Order</router-link>

            <template scope="props">
                <tr @click="move(props.item)">
                    <td>{{props.item.id}}</td>
                    <td>{{props.item.date}}</td>
                    <td>{{props.item.number}}</td>
                    <td>{{props.item.vendor.person}}</td>
                    <td>{{props.item.title}}</td>
                    <td>
                        {{props.item.total}}
                        <small>{{props.item.currency.code}}</small>
                    </td>
                    <td><status :id="props.item.status_id"></status></td>
                </tr>
            </template>
        </index>
    </div>
</template>
<script type="text/javascript">
    import Index from '../../components/Index.vue'
    import Status from '../../components/status/Invoice.vue'
    export default {
        name: 'PurchaseOrderIndex',
        data() {
            return {
                resource: 'purchase-orders',
                thead: [
                    { title: 'ID', key: 'id', sort: true },
                    { title: 'Date', key: 'date', sort: true },
                    { title: 'Number', key: 'number', sort: false },
                    { title: 'Vendor', key: 'vendor', sort: false },
                    { title: 'Title', key: 'title', sort: true },
                    { title: 'Amount', key: 'total', sort: true },
                    { title: 'Status', key: 'status_id', sort: true }
                ],
                filter: [
                    'id', 'number', 'sub_total', 'total', 'title', 'vendor_id',
                    'currency_id', 'date', 'due_date', 'status_id', 'reference', 'amount_paid',
                    'discount', 'created_at',

                    // filter relation
                    'vendor.id', 'vendor.person', 'vendor.company', 'vendor.email', 'vendor.telephone',
                    'vendor.billing_address', 'vendor.shipping_address', 'vendor.currency_id',
                    'vendor.created_at'
                ]
            }
        },
        watch: {
            '$route': 'fetchData'
        },
        created() {
            this.fetchData()
        },
        methods: {
            move(item) {
                this.$router.push(`/purchase-orders/${item.id}`)
            },
            fetchData() {
                this.$store.dispatch('fetchIndex', {
                    resource: 'purchase_orders'
                })
            }
        },
        components: {
            Status,
            Index
        },
    }
</script>