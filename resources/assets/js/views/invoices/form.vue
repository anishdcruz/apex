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
                            <typeahead @changed="changeCurrency" :items="option.clients"
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
                    <div class="col-sm-7">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" v-model="form.title">
                            <small class="e-text" v-if="errors.title">{{errors.title[0]}}</small>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-4">
                                <label>Date</label>
                                <input type="date" class="form-control" v-model="form.date">
                                <small class="e-text" v-if="errors.date">{{errors.date[0]}}</small>
                            </div>
                            <div class="col-sm-4">
                                <label>Due Date</label>
                                <input type="date" class="form-control" v-model="form.due_date">
                                <small class="e-text" v-if="errors.due_date">{{errors.due_date[0]}}</small>
                            </div>
                            <div class="col-sm-4">
                                <label>
                                    Reference
                                    <small>Optional</small>
                                </label>
                                <input type="text" class="form-control" v-model="form.reference">
                                <small class="e-text" v-if="errors.reference">{{errors.reference[0]}}</small>
                            </div>
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
                            <th>Item Code</th>
                            <th>Description</th>
                            <th>Unit Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in form.items">
                            <td :class="['w-2', errors['items.' + index + '.item_code'] ? 'e-table' : '']">
                                <input type="text" class="form_table-control" v-model="item.item_code">
                            </td>
                            <td :class="['w-5', errors['items.' + index + '.description'] ? 'e-table' : '']">
                                <textarea class="form_table-control" v-model="item.description"></textarea>
                            </td>
                            <td :class="['w-2 right', errors['items.' + index + '.unit_price'] ? 'e-table' : '']">
                                <input type="text" class="form_table-control" v-model="item.unit_price">
                            </td>
                            <td :class="['w-1 center', errors['items.' + index + '.qty'] ? 'e-table' : '']">
                                <input type="text" class="form_table-control" v-model="item.qty">
                            </td>
                            <td class="w-2 right">
                                <span class="form_table-text">
                                    {{parseFloat(item.qty) * parseFloat(item.unit_price)}}
                                </span>
                            </td>
                            <td class="form_table-delete">
                                <button @click="remove('items', index)">&times;</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">
                                <button class="btn" @click="addLine('items')">Add Line</button>
                                <product @add="addItems"></product>
                            </td>
                            <td colspan="2" class="form_table-title">
                                <span>Sub Total</span>
                            </td>
                            <td>
                                <span class="form_table-text form_table-total">{{subTotal}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2" class="form_table-title">
                                <span>Discount</span>
                            </td>
                            <td :class="[errors.discount ? 'e-table' : '']">
                                <input type="text" class="form_table-control form_table-total" v-model="form.discount">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2" class="form_table-title">
                                <span>Grand Total</span>
                            </td>
                            <td>
                                <span class="form_table-text form_table-total">{{total}}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="panel">
            <div class="panel-body">
            <table class="form_table">
                <thead>
                    <tr>
                        <th>Terms and Conditions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(term, index) in form.terms">
                        <td :class="['w-12', errors['terms.' + index + '.description'] ? 'e-table' : '']">
                            <textarea class="form_table-control" v-model="term.description"></textarea>
                        </td>
                        <td class="form_table-delete">
                            <button @click="remove('terms', index)">&times;</button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <div class="form_table-btns">
                                <button class="btn" @click="addLine('terms')">Add Line</button>
                                <term @add="addTerms"></term>
                            </div>
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
                redirect: '/invoices',
                title: 'Create Invoice',
                initalize: 'invoices/create',
                store: 'invoices',
                method: 'post',
                button: 'Create'
            }
        },
        created() {
            if(this.$route.meta.mode === 'edit') {
                this.title = 'Edit Invoice'
                this.initalize = `invoices/${this.$route.params.id}/edit`
                this.store = `invoices/${this.$route.params.id}`
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
            },
            subTotal() {
                return this.form.items.reduce(function(carry, item) {
                  return carry + parseFloat(item.unit_price) * parseFloat(item.qty)
                }, 0)
            },
            total() {
                return this.subTotal - parseFloat(this.form.discount)
            }
        },
        watch: {
            '$route': 'fetchData'
        },
        methods: {
            addItems(event) {
                var vm = this
                event.target.value.forEach(function(x) {
                    vm.form.items.push({
                        item_code: x.item_code,
                        description: x.description,
                        unit_price: x.unit_price,
                        qty: 1
                    })
                })
            },
            addTerms(event) {
                var vm = this
                event.target.value.forEach(function(x) {
                    vm.form.terms.push({
                        description: x.description
                    })
                })
            },
            addLine(type) {
                if(type === 'items') {
                    this.form.items.push({
                        item_code: '',
                        description: '',
                        unit_price: 0,
                        qty: 1
                    })
                } else {
                    this.form.terms.push({
                        description: ''
                    })
                }
            },
            remove(type, index) {
                // prevent removal of last item
                if(this.form[type].length > 1) {
                    this.form[type].splice(index, 1)
                }
            },
            changeCurrency(event) {
                this.form.currency_id = event.target.value.currency_id
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