<template>
    <div class="view">
        <div class="panel">
            <div class="panel-heading">
                <p class="panel-title">
                    <span>Delivery Note</span>
                    <status :id="model.status_id" class="status-lg"></status>
                </p>
                <div class="panel-controls">
                    <div class="btn-group">
                        <button @click="$router.back()" class="btn">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                    </div>
                    <div class="btn-group">
                        <a target="_blank" :href="'/api/deliveries/' + model.id + '/pdf'" class="btn">
                            <i class="fa fa-file-pdf-o"></i>
                        </a>
                        <a target="_blank" :href="'/api/deliveries/' + model.id + '/pdf?opt=download'" class="btn">
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                    <div class="btn-group">
                        <router-link class="btn btn-primary" :to="pickLink" v-if="model.status_id === 1">
                            Mark as Picked
                        </router-link>
                        <router-link class="btn btn-secondary" :to="delLink" v-if="model.status_id === 2">
                            Mark as Delivered
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="document">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong>Delivery To:</strong><br>
                                    <pre>{{model.address}}</pre>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-sm-offset-1">
                            <table class="table-summary">
                                <tbody>
                                    <tr>
                                        <td>Number:</td>
                                        <td>{{model.number}}</td>
                                    </tr>
                                    <tr>
                                        <td>Delivery Date:</td>
                                        <td>{{model.date | formatDate}}</td>
                                    </tr>
                                    <tr>
                                        <td>Sales Order:</td>
                                        <td>{{sales.number}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th>Item Code</th>
                                <th>Description</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in model.items">
                                <td>{{item.item_code}}</td>
                                <td><pre>{{item.description}}</pre></td>
                                <td>{{item.qty}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Status from '../../components/status/Delivery.vue'
    export default {
        name: 'DeliveryShow',
        components: {
            Status
        },
        created() {
            this.fetchData()
        },
        watch: {
            '$route': 'fetchData'
        },
        computed: {
            model() {
                return this.$store.getters.model
            },
            sales() {
                return this.$store.getters.sales
            },
            client() {
                return this.$store.getters.client
            },
            pickLink() {
                return `/deliveries/${this.model.id}/status/picked`
            },
            delLink() {
                return `/deliveries/${this.model.id}/status/delivered`
            }
        },
        methods: {
            fetchData() {
                this.$store.dispatch('fetchById', {
                    path: `deliveries/${this.$route.params.id}`
                })
            }
        }
    }
</script>