<template>
    <div class="view">
        <div class="panel">
            <div class="panel-heading">
                <p class="panel-title">{{title}}</p>
            </div>
            <div class="panel-body">
                <div class="row form">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>
                                Item Code
                                <small>
                                    <i class="info">*</i>
                                    Auto Generated
                                </small>
                            </label>
                            <input type="text" class="form-control" v-model="form.item_code" disabled>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" v-model="form.description"></textarea>
                            <small class="e-text" v-if="errors.description">{{errors.description[0]}}</small>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Unit Price</label>
                            <input type="text" class="form-control" v-model="form.unit_price">
                            <small class="e-text" v-if="errors.unit_price">{{errors.unit_price[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label>Vendor Ref</label>
                            <input type="text" class="form-control" v-model="form.vendor_ref">
                            <small class="e-text" v-if="errors.vendor_ref">{{errors.vendor_ref[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label>Vendor Price</label>
                            <input type="text" class="form-control" v-model="form.vendor_price">
                            <small class="e-text" v-if="errors.vendor_price">{{errors.vendor_price[0]}}</small>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Currency</label>
                            <typeahead :items="option.currencies" v-model="form.currency_id"></typeahead>
                            <small class="e-text" v-if="errors.currency_id">{{errors.currency_id[0]}}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="panel-controls">
                    <button class="btn" @click="$router.back()">Cancel</button>
                    <button class="btn btn-primary" @click="submit" v-text="button"></button>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Typeahead from '../../components/Typeahead.vue'
    export default {
        data() {
            return {
                redirect: '/products',
                title: 'Create Product',
                initalize: 'products/create',
                store: 'products',
                method: 'post',
                button: 'Create'
            }
        },
        created() {
            if(this.$route.meta.mode === 'edit') {
                this.title = 'Edit Product'
                this.initalize = `products/${this.$route.params.id}/edit`
                this.store = `products/${this.$route.params.id}`
                this.method = 'put'
                this.button = 'Save'
            }
            this.fetchData()
        },
        computed: {
            option() {
                return this.$store.getters.option
            },
            form() {
                return this.$store.getters.form
            },
            errors() {
                return this.$store.getters.errors
            }
        },
        watch: {
            '$route': 'fetchData'
        },
        methods: {
            fetchData() {
                this.$store.dispatch('fetchFormById', {
                    path: this.initalize
                })
            },
            submit() {
                this.$store.dispatch('storeById', {
                    form: this.form,
                    store: this.store,
                    method: this.method,
                    redirect: this.redirect,
                    router: this.$router
                })
            }
        },
        components: {
            Typeahead
        }
    }
</script>