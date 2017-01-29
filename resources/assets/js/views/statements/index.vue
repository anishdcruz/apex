<template>
    <div class="view">
        <index :thead="thead" :resource="resource" :filter="filter">
            <span slot="title">Statement</span>
            <router-link to="/statements/create" class="btn btn-primary" slot="create">Generate Statement</router-link>

            <template scope="props">
                <tr @click="move(props.item)">
                    <td>{{props.item.id}}</td>
                    <td>{{props.item.number}}</td>
                    <td>{{props.item.client.person}}</td>
                    <td>{{props.item.from_date}}</td>
                    <td>{{props.item.to_date}}</td>
                    <td>
                        {{props.item.total}}
                        <small>{{props.item.currency.code}}</small>
                    </td>
                    <td>{{props.item.created_at}}</td>
                </tr>
            </template>
        </index>
    </div>
</template>
<script type="text/javascript">
    import Index from '../../components/Index.vue'
    export default {
        name: 'StatementIndex',
        data() {
            return {
                resource: 'statements',
                thead: [
                    { title: 'ID', key: 'id', sort: true },
                    { title: 'Number', key: 'number', sort: false },
                    { title: 'Client', key: 'client', sort: false },
                    { title: 'From', key: 'from_date', sort: true },
                    { title: 'To', key: 'to_date', sort: true },
                    { title: 'Balance', key: 'total', sort: true },
                    { title: 'Created At', key: 'created_at', sort: true }
                ],
                filter: [
                    'id', 'client_id', 'currency_id', 'from_date', 'to_date',
                    'total', 'created_at',

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
                this.$router.push(`/statements/${item.id}`)
            },
            fetchData() {
                this.$store.dispatch('fetchIndex', {
                    resource: this.resource
                })
            }
        },
        components: {
            Index
        },
    }
</script>