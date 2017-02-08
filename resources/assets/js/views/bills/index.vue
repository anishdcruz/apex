<template>
    <div class="view">
        <index :thead="thead" :resource="resource" :filter="filter">
            <span slot="title">Bill</span>
            <router-link to="/bills/create" class="btn btn-primary" slot="create">Create Bill</router-link>

            <template scope="props">
                <tr @click="move(props.item)">
                    <td>{{props.item.id}}</td>
                    <td>{{props.item.date | formatDate}}</td>
                    <td>{{props.item.due_date | formatDate}}</td>
                    <td>{{props.item.number}}</td>
                    <td>{{props.item.vendor.person}}</td>
                    <td>
                        {{props.item.total | formatMoney(props.item.currency, true) }}
                    </td>
                    <td><status :id="props.item.status_id"></status></td>
                </tr>
            </template>
        </index>
    </div>
</template>
<script type="text/javascript">
    import Index from '../../components/Index.vue'
    import Status from '../../components/status/Bill.vue'
    export default {
        name: 'BillIndex',
        data() {
            return {
                resource: 'bills',
                thead: [
                    { title: 'ID', key: 'id', sort: true },
                    { title: 'Date', key: 'date', sort: true },
                    { title: 'Due Date', key: 'due_date', sort: true },
                    { title: 'Number', key: 'number', sort: false },
                    { title: 'Vendor', key: 'vendor', sort: false },
                    { title: 'Amount', key: 'total', sort: true },
                    { title: 'Status', key: 'status_id', sort: true }
                ],
                filter: [
                    'id', 'number', 'vendor_id', 'currency_id', 'date', 'due_date', 'purchase_order_id',
                    'vendor_invoice_no', 'status_id', 'total', 'amount_paid', 'created_at',

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
                this.$router.push(`/bills/${item.id}`)
            },
            fetchData() {
                this.$store.dispatch('fetchIndex', {
                    resource: this.resource
                })
            }
        },
        components: {
            Status,
            Index
        },
    }
</script>