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
                            <label>Client</label>
                            <typeahead @changed="clientChanged" :items="option.clients"
                                v-model="form.client_id"></typeahead>
                            <small class="e-text" v-if="errors.client_id">{{errors.client_id[0]}}</small>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label>Currency</label>
                                <typeahead :items="option.currencies" v-model="form.currency_id"></typeahead>
                                <small class="e-text" v-if="errors.currency_id">{{errors.currency_id[0]}}</small>
                            </div>
                            <div class="col-sm-6">
                                <label>
                                    Number
                                    <small>
                                        Auto Generated
                                    </small>
                                </label>
                                <input type="text" class="form-control" v-model="form.number" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label>Payment Date</label>
                                <input type="date" class="form-control" v-model="form.date">
                                <small class="e-text" v-if="errors.date">{{errors.date[0]}}</small>
                            </div>
                            <div class="col-sm-6">
                                <label>Amount Received</label>
                                <input type="text" class="form-control" v-model="form.amount_received">
                                <small class="e-text" v-if="errors.amount_received">{{errors.amount_received[0]}}</small>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label>Payment Mode</label>
                                <select class="form-control" v-model="form.payment_mode">
                                    <option>Cheque</option>
                                    <option>Cash</option>
                                    <option>Bank_transfer</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label>
                                    Reference
                                    <small>Bank, Check #, etc.</small>
                                </label>
                                <input type="text" class="form-control" v-model="form.reference">
                                <small class="e-text" v-if="errors.reference">{{errors.reference[0]}}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>
                                Internal Note
                                <small>Optional</small>
                            </label>
                            <textarea class="form-control" v-model="form.internal_note"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-body">
                <table class="form_table">
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Invoice Date</th>
                            <th>Invoice Title</th>
                            <th>Invoice Total</th>
                            <th>Invoice Due</th>
                            <th>Amount Applied</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in form.items">
                            <td class="w-1 left">
                                <span class="form_table-text">
                                    {{item.number}}
                                </span>
                            </td>
                            <td class="w-1 left">
                                <span class="form_table-text">
                                    {{item.date}}
                                </span>
                            </td>
                            <td class="w-3 left">
                                <span class="form_table-text">
                                    {{item.title}}
                                </span>
                            </td>
                            <td class="w-2 right">
                                <span class="form_table-text">
                                    {{item.total}}
                                </span>
                            </td>
                            <td class="w-2 right">
                                <span class="form_table-text">
                                    {{item.amount_due}}
                                </span>
                            </td>
                            <td :class="['w-2 right', errors['items.' + index + '.applied_amount'] ? 'e-table' : '']">
                                <input type="text" class="form_table-control" v-model="item.applied_amount">
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td class="form_table-title">
                                <span>Total Amount Applied</span>
                            </td>
                            <td>
                                <span class="form_table-text form_table-total">{{total}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td class="form_table-title">
                                <span>Total Amount Due</span>
                            </td>
                            <td>
                                <span class="form_table-text form_table-total">{{due}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td class="form_table-title">
                                <span>Total Amount Received</span>
                            </td>
                            <td>
                                <span class="form_table-text form_table-total">{{form.amount_received}}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
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
    import Product from '../../components/modals/Product.vue'
    import Typeahead from '../../components/Typeahead.vue'
    import Term from '../../components/modals/Term.vue'
    export default {
        data() {
            return {
                redirect: '/received-payments',
                title: 'Create Received Payment',
                initalize: 'received_payments/create',
                store: 'received_payments',
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
            },
            total() {
                return this.form.items.reduce(function(carry, item) {
                  return carry + parseFloat(item.applied_amount)
                }, 0)
            },
            due() {
                return this.form.items.reduce(function(carry, item) {
                  return carry + parseFloat(item.amount_due)
                }, 0)
            }
        },
        watch: {
            '$route': 'fetchData'
        },
        methods: {
            fetchInvoices() {
                this.$store.dispatch('fetchInvoices', {
                    path: 'received_payments/client/' + this.form.client_id
                })
            },
            clientChanged(event) {
                this.form.currency_id = event.target.value.currency_id
                this.fetchInvoices()
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
            Typeahead,
            Product,
            Term
        }
    }
</script>