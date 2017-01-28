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
                            <label>Person</label>
                            <input type="text" class="form-control" v-model="form.person">
                            <small class="e-text" v-if="errors.person">{{errors.person[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <input type="text" class="form-control" v-model="form.company">
                            <small class="e-text" v-if="errors.company">{{errors.company[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="text" class="form-control" v-model="form.email">
                            <small class="e-text" v-if="errors.email">{{errors.email[0]}}</small>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Telephone</label>
                            <input type="text" class="form-control" v-model="form.telephone">
                            <small class="e-text" v-if="errors.telephone">{{errors.telephone[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label>Billing Address</label>
                            <textarea class="form-control" v-model="form.billing_address"></textarea>
                            <small class="e-text" v-if="errors.billing_address">{{errors.billing_address[0]}}</small>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Currency</label>
                            <typeahead :items="option.currencies" v-model="form.currency_id"></typeahead>
                            <small class="e-text" v-if="errors.currency_id">{{errors.currency_id[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label>
                                Shipping Address
                                <small>
                                    <a @click.stop="copyBillingAddress">Copy Billing Address</a>
                                </small>
                            </label>
                            <textarea class="form-control" v-model="form.shipping_address"></textarea>
                            <small class="e-text" v-if="errors.shipping_address">{{errors.shipping_address[0]}}</small>
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
                redirect: '/clients',
                title: 'Create Client',
                initalize: 'clients/create',
                store: 'clients',
                method: 'post',
                button: 'Create'
            }
        },
        created() {
            if(this.$route.meta.mode === 'edit') {
                this.title = 'Edit Client'
                this.initalize = `clients/${this.$route.params.id}/edit`
                this.store = `clients/${this.$route.params.id}`
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
            copyBillingAddress() {
                this.form.shipping_address = this.form.billing_address
            },
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