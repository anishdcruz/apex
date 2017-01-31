<template>
    <div class="view">
        <index :thead="thead" :resource="resource" :filter="filter">
            <span slot="title">Vendors</span>
            <router-link to="/vendors/create" class="btn btn-primary" slot="create">Create Vendor</router-link>

            <template scope="props">
                <tr @click="move(props.item)">
                    <td>{{props.item.id}}</td>
                    <td>{{props.item.person}}</td>
                    <td>{{props.item.company}}</td>
                    <td>{{props.item.email}}</td>
                    <td>{{props.item.telephone}}</td>
                    <td>{{props.item.created_at}}</td>
                </tr>
            </template>
        </index>
    </div>
</template>
<script type="text/javascript">
    import Index from '../../components/Index.vue'
    export default {
        name: 'VendorIndex',
        data() {
            return {
                resource: 'vendors',
                thead: [
                    { title: 'ID', key: 'id', sort: true },
                    { title: 'Person', key: 'person', sort: true },
                    { title: 'Company', key: 'company', sort: true },
                    { title: 'Email Address', key: 'email', sort: true },
                    { title: 'Phone Number', key: 'telephone', sort: true },
                    { title: 'Created At', key: 'created_at', sort: true }
                ],
                filter: [
                    'id', 'person', 'company', 'email', 'telephone',
                    'billing_address', 'shipping_address',
                    'created_at'
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
                this.$router.push(`/vendors/${item.id}`)
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