<template>
    <div class="view">
        <index :thead="thead" :resource="resource" :filter="filter">
            <span slot="title">Expense</span>
            <router-link to="/expenses/create" class="btn btn-primary" slot="create">Create Expense</router-link>

            <template scope="props">
                <tr @click="move(props.item)">
                    <td>{{props.item.id}}</td>
                    <td>{{props.item.date | formatDate}}</td>
                    <td>{{props.item.vendor.person}}</td>
                    <td>
                        {{props.item.amount}}
                        <small>{{props.item.currency.code}}</small>
                    </td>
                    <td>{{props.item.paid_through}}</td>
                    <td>{{props.item.created_at}}</td>
                </tr>
            </template>
        </index>
    </div>
</template>
<script type="text/javascript">
    import Index from '../../components/Index.vue'
    export default {
        name: 'ExpensesIndex',
        data() {
            return {
                resource: 'expenses',
                thead: [
                    { title: 'ID', key: 'id', sort: true },
                    { title: 'Date', key: 'date', sort: true },
                    { title: 'Vendor', key: 'vendor', sort: false },
                    { title: 'Amount', key: 'amount', sort: true },
                    { title: 'Paid Through', key: 'paid_though', sort: true },
                    { title: 'Created At', key: 'created_at', sort: true }
                ],
                filter: [
                    'id', 'date', 'account', 'amount',
                    'paid_though','created_at',

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
                this.$router.push(`/expenses/${item.id}`)
            },
            fetchData() {
                this.$store.dispatch('fetchIndex', {
                    resource: 'expenses'
                })
            }
        },
        components: {
            Index
        },
    }
</script>