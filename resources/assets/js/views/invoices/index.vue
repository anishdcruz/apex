<template>
    <div class="view">
        <index :thead="thead" :resource="resource" :filter="filter">
            <span slot="title">Invoice</span>
            <router-link to="/invoices/create" class="btn btn-primary" slot="create">Create Invoice</router-link>

            <template scope="props">
                <tr @click="move(props.item)">
                    <td>{{props.item.id}}</td>
                    <td>{{props.item.date | formatDate}}</td>
                    <td>{{props.item.number}}</td>
                    <td>{{props.item.client.person}}</td>
                    <td>{{props.item.title}}</td>
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
    import Status from '../../components/status/Invoice.vue'
    export default {
        name: 'InvoiceIndex',
        data() {
            return {
                resource: 'invoices',
                thead: [
                    { title: 'ID', key: 'id', sort: true },
                    { title: 'Date', key: 'date', sort: true },
                    { title: 'Number', key: 'number', sort: false },
                    { title: 'Client', key: 'client', sort: false },
                    { title: 'Title', key: 'title', sort: true },
                    { title: 'Amount', key: 'total', sort: true },
                    { title: 'Status', key: 'status_id', sort: true }
                ],
                filter: [
                    'id', 'number', 'sub_total', 'total', 'title', 'client_id',
                    'currency_id', 'date', 'due_date', 'status_id', 'reference', 'amount_paid',
                    'discount', 'created_at',

                    // filter relation
                    'client.id', 'client.person', 'client.company', 'client.email', 'client.telephone',
                    'client.billing_address', 'client.shipping_address', 'client.currency_id',
                    'client.created_at'
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
                this.$router.push(`/invoices/${item.id}`)
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