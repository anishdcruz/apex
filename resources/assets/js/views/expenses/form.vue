<template>
    <div class="view">
        <div class="panel">
            <div class="panel-heading">
                <p class="panel-title">{{title}}</p>
            </div>
            <div class="panel-body">
                <div class="row form">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Vendor</label>
                            <typeahead :items="option.vendors" v-model="form.vendor_id"></typeahead>
                            <small class="e-text" v-if="errors.vendor_id">{{errors.vendor_id[0]}}</small>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label>Currency</label>
                                <typeahead :items="option.currencies" v-model="form.currency_id"></typeahead>
                                <small class="e-text" v-if="errors.currency_id">{{errors.currency_id[0]}}</small>
                            </div>
                            <div class="col-sm-6">
                                <label>Amount Paid</label>
                                <input type="text" class="form-control" v-model="form.amount">
                                <small class="e-text" v-if="errors.amount">{{errors.amount[0]}}</small>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label>Date</label>
                                <input type="date" class="form-control" v-model="form.date">
                                <small class="e-text" v-if="errors.date">{{errors.date[0]}}</small>
                            </div>
                            <div class="col-sm-6">
                                <label>Account</label>
                                <select class="form-control" v-model="form.account">
                                    <option>expenses</option>
                                </select>
                                <small class="e-text" v-if="errors.account">{{errors.account[0]}}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Payment Mode</label>
                            <select class="form-control" v-model="form.paid_through">
                                <option>petty_cash</option>
                                <option>cheque</option>
                                <option>bank_transfer</option>
                            </select>
                            <small class="e-text" v-if="errors.paid_through">{{errors.paid_through[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label>
                                Payment Reference
                                <small>Optional</small>
                            </label>
                            <input type="text" class="form-control" v-model="form.payment_reference">
                            <small class="e-text" v-if="errors.payment_reference">{{errors.payment_reference[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label>
                                Vendor Receipt
                                <small>Optional</small>
                            </label>
                            <input type="text" class="form-control" v-model="form.vendor_receipt">
                            <small class="e-text" v-if="errors.vendor_receipt">{{errors.vendor_receipt[0]}}</small>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>
                                Upload File
                                <small>Optional</small>
                            </label>
                            <input type="file" class="form-control" @change="upload">
                            <small class="e-text" v-if="errors.image">{{errors.image[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label>
                                Internal Note
                                <small>Optional</small>
                            </label>
                            <textarea class="form-control" v-model="form.internal_note"></textarea>
                            <small class="e-text" v-if="errors.internal_note">{{errors.internal_note[0]}}</small>
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
                redirect: '/expenses',
                title: 'Create Expense',
                initalize: 'expenses/create',
                store: 'expenses',
                method: 'post',
                button: 'Create'
            }
        },
        created() {
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
            upload(e) {
                var input = e.target
                if (input.files && input.files[0]) {
                    this.form.image = input.files[0]
                }
            },
            fetchData() {
                this.$store.dispatch('fetchFormById', {
                    path: this.initalize
                })
            },
            submit() {
                var multipartForm = new FormData()
                for (var k in this.form) {
                    if (this.form.hasOwnProperty(k)) {
                        multipartForm.append(k, this.form[k])
                    }
                }

                this.$store.dispatch('storeById', {
                    form: multipartForm,
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
</script>`