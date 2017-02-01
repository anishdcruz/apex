<template>
    <div class="view">
        <index :thead="thead" :resource="resource" :filter="filter">
            <span slot="title">Products</span>
            <router-link to="/products/create" class="btn btn-primary" slot="create">Create Product</router-link>

            <template scope="props">
                <tr @click="move(props.item)">
                    <td>{{props.item.id}}</td>
                    <td>{{props.item.item_code}}</td>
                    <td>{{props.item.description}}</td>
                    <td>{{props.item.unit_price | formatMoney(props.item.currency, true)}}</td>
                    <td>{{props.item.vendor_ref}}</td>
                    <td>{{props.item.vendor_price | formatMoney(props.item.currency, true)}}</td>
                </tr>
            </template>
        </index>
    </div>
</template>
<script type="text/javascript">
    import Index from '../../components/Index.vue'
    export default {
        name: 'ClientIndex',
        data() {
            return {
                resource: 'products',
                thead: [
                    { title: 'ID', key: 'id', sort: true },
                    { title: 'Item Code', key: 'item_code', sort: true },
                    { title: 'Description', key: 'description', sort: false },
                    { title: 'Unit Price', key: 'unit_price', sort: true },
                    { title: 'Vendor Ref', key: 'vendor_ref', sort: true },
                    { title: 'Vendor Price', key: 'vendor_price', sort: true }
                ],
                filter: [
                    'id', 'description', 'unit_price', 'vendor_price',
                    'vendor_ref', 'created_at'
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
                this.$router.push(`/products/${item.id}`)
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