<template>
    <div class="view">
        <div class="panel">
            <div class="panel-heading">
                <p class="panel-title">{{title}}</p>
            </div>
            <div class="panel-body">
                <div class="row form">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Client</label>
                            <span class="form-control" disabled>{{form.client_name}}</span>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label>
                                    Number
                                    <small>
                                        Auto Generated
                                    </small>
                                </label>
                                <input type="text" class="form-control" v-model="form.number" disabled>
                            </div>
                            <div class="col-sm-6">
                                <label>Date</label>
                                <input type="date" class="form-control" v-model="form.date">
                                <small class="e-text" v-if="errors.date">{{errors.date[0]}}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Delivery Address</label>
                            <textarea class="form-control" v-model="form.address"></textarea>
                            <small class="e-text" v-if="errors.address">{{errors.address[0]}}</small>
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
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in form.items">
                            <td :class="['w-2', errors['items.' + index + '.item_code'] ? 'e-table' : '']">
                                <input type="text" class="form_table-control" v-model="item.item_code">
                            </td>
                            <td :class="['w-9', errors['items.' + index + '.description'] ? 'e-table' : '']">
                                <textarea class="form_table-control" v-model="item.description"></textarea>
                            </td>
                            <td :class="['w-1 right', errors['items.' + index + '.qty'] ? 'e-table' : '']">
                                <input type="text" class="form_table-control" v-model="item.qty">
                            </td>
                            <td class="form_table-delete">
                                <button @click="remove('items', index)">&times;</button>
                            </td>
                        </tr>
                    </tbody>
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
                redirect: '/deliveries',
                title: 'Create Delivery Note',
                initalize: `sales_orders/${this.$route.params.id}/edit?convert=delivery`,
                store: 'deliveries',
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
            remove(type, index) {
                // prevent removal of last item
                if(this.form[type].length > 1) {
                    this.form[type].splice(index, 1)
                }
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
        }
    }
</script>