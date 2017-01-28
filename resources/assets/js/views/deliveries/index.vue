<template>
    <div class="view">
        <index :thead="thead" :resource="resource" :filter="filter">
            <span slot="title">Delivery Note</span>
            <template scope="props">
                <tr @click="move(props.item)">
                    <td>{{props.item.id}}</td>
                    <td>{{props.item.date}}</td>
                    <td>{{props.item.number}}</td>
                    <td>{{props.item.client.person}}</td>
                    <td>{{props.item.sales.number}}</td>
                    <td>{{props.item.created_at}}</td>
                    <td><status :id="props.item.status_id"></status></td>
                </tr>
            </template>
        </index>
    </div>
</template>
<script type="text/javascript">
    import Index from '../../components/Index.vue'
    import Status from '../../components/status/Delivery.vue'
    export default {
        name: 'DeliveryIndex',
        data() {
            return {
                resource: 'deliveries',
                thead: [
                    { title: 'ID', key: 'id', sort: true },
                    { title: 'Date', key: 'date', sort: true },
                    { title: 'Number', key: 'number', sort: false },
                    { title: 'Client', key: 'client', sort: false },
                    { title: 'Sales Order', key: 'sales-orders', sort: false },
                    { title: 'Created At', key: 'created_at', sort: true },
                    { title: 'Status', key: 'status_id', sort: true }
                ],
                filter: [
                    'id', 'client_id', 'date', 'status_id', 'sales_order_id',
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
                this.$router.push(`/deliveries/${item.id}`)
            },
            fetchData() {
                this.$store.dispatch('fetchIndex', {
                    resource: 'deliveries'
                })
            }
        },
        components: {
            Status,
            Index
        },
    }
</script>