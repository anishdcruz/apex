<template>
    <div class="view">
        <index :thead="thead">
            <template scope="props">
                <tr>
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
        name: 'ClientIndex',
        data() {
            return {
                thead: [
                    { title: 'ID', key: 'id', sort: true },
                    { title: 'Person', key: 'person', sort: true },
                    { title: 'Company', key: 'company', sort: true },
                    { title: 'Email Address', key: 'email', sort: true },
                    { title: 'Phone Number', key: 'telephone', sort: true },
                    { title: 'Created At', key: 'created_at', sort: true }
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
            fetchData() {
                this.$store.dispatch('fetchIndex', {
                    resource: 'clients'
                })
            }
        },
        components: {
            Index
        },
    }
</script>