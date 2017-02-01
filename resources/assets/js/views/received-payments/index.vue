<template>
    <div class="view">
        <index :thead="thead" :resource="resource" :filter="filter">
            <span slot="title">Received Payment</span>
            <router-link to="/received-payments/create" class="btn btn-primary" slot="create">Create Received Payment</router-link>

            <template scope="props">
                <tr @click="move(props.item)">
                    <td>{{props.item.id}}</td>
                    <td>{{props.item.date | formatDate}}</td>
                    <td>{{props.item.number}}</td>
                    <td>{{props.item.client.person}}</td>
                    <td>
                        {{props.item.amount_received | formatMoney(props.item.currency, true)}}
                    </td>
                    <td>{{props.item.created_at}}</td>
                </tr>
            </template>
        </index>
    </div>
</template>
<script type="text/javascript">
    import Index from '../../components/Index.vue'
    import Status from '../../components/status/Invoice.vue'
    export default {
        name: 'ReceivedPaymentIndex',
        data() {
            return {
                resource: 'received-payments',
                thead: [
                    { title: 'ID', key: 'id', sort: true },
                    { title: 'Payment Date', key: 'date', sort: true },
                    { title: 'Number', key: 'number', sort: false },
                    { title: 'Client', key: 'client', sort: false },
                    { title: 'Amount Received', key: 'amount_received', sort: true },
                    { title: 'Created At', key: 'created_at', sort: true }
                ],
                filter: [
                    'id', 'amount_received', 'date', 'payment_mode',
                    'reference',  'amount_used', 'number', 'internal_note',
                    'created_at',

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
                this.$router.push(`/received-payments/${item.id}`)
            },
            fetchData() {
                this.$store.dispatch('fetchIndex', {
                    resource: 'received_payments'
                })
            }
        },
        components: {
            Status,
            Index
        },
    }
</script>