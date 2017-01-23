<template>
    <div class="view">
        <div class="panel">
            <div class="panel-heading">
                <p class="panel-title">{{model.item_code}}</p>
                <div class="panel-controls">
                    <button @click="$router.back()" class="btn">Back</button>
                    <router-link :to="editLink" class="btn btn-secondary">Edit</router-link>
                    <button class="btn btn-danger">Delete</button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="show-item">
                            <label>Item Code</label>
                            <p v-text="model.item_code"></p>
                        </div>
                        <div class="show-item">
                            <label>Unit Price</label>
                            <p>
                                <span v-text="model.unit_price"></span>
                                <small v-text="currency.code"></small>
                            </p>
                        </div>
                        <div class="show-item">
                            <label>Created At</label>
                            <p v-text="model.created_at"></p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="show-item">
                            <label>Description</label>
                            <pre v-text="model.description"></pre>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="show-item">
                            <label>Vendor Refernce</label>
                            <p v-text="model.vendor_ref"></p>
                        </div>
                        <div class="show-item">
                            <label>Vendor Price</label>
                            <p>
                                <span v-text="model.vendor_price"></span>
                                <small v-text="currency.code"></small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    export default {
        name: 'ProductShow',
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
            currency() {
                return this.$store.getters.currency
            },
            editLink() {
                return `/products/${this.model.id}/edit`
            }
        },
        methods: {
            fetchData() {
                this.$store.dispatch('fetchById', {
                    path: `products/${this.$route.params.id}`
                })
            }
        }
    }
</script>