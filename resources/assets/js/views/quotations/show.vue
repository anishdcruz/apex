<template>
    <div class="view">
        <div class="panel">
            <div class="panel-heading">
                <p class="panel-title">
                    <status :id="model.status_id" class="status-lg"></status>
                    <span>{{model.title}}</span>
                </p>
                <div class="panel-controls">
                    <button @click="$router.back()" class="btn">Back</button>
                    <router-link :to="editLink" class="btn btn-secondary">Edit</router-link>
                    <button class="btn btn-danger">Delete</button>
                </div>
            </div>
            <div class="panel-body">
                <div class="document">
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>To:</strong><br>
                            <pre>{{client.person}},<br>{{client.company}},<br>{{client.billing_address}}</pre>
                        </div>
                        <div class="col-sm-3 col-sm-offset-5">
                            <table class="table-summary">
                                <tbody>
                                    <tr>
                                        <td>Number:</td>
                                        <td>{{model.number}}</td>
                                    </tr>
                                    <tr>
                                        <td>Date:</td>
                                        <td>{{model.date}}</td>
                                    </tr>
                                    <tr>
                                        <td>Expiry Date:</td>
                                        <td>{{model.expiry_date}}</td>
                                    </tr>
                                    <tr>
                                        <td>Currency:</td>
                                        <td>{{currency.code}}</td>
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
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in model.items">
                                <td>{{item.item_code}}</td>
                                <td><pre>{{item.description}}</pre></td>
                                <td>{{item.unit_price}}</td>
                                <td>{{item.qty}}</td>
                                <td>{{item.qty * item.unit_price}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">Sub Total</td>
                                <td>{{model.sub_total}}</td>
                            </tr>
                            <tr v-if="model.discount">
                                <td colspan="2"></td>
                                <td colspan="2">Discount</td>
                                <td>{{model.discount}}</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">
                                    <strong>Grand Total</strong>
                                </td>
                                <td>
                                    <strong>{{model.total}}</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="document-terms">
                                <strong>Terms and Conditions</strong>
                                <ul>
                                    <li v-for="term in model.terms">
                                        <pre>{{term.description}}</pre>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Status from '../../components/status/Quotation.vue'
    export default {
        name: 'QuotationShow',
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
            currency() {
                return this.$store.getters.currency
            },
            client() {
                return this.$store.getters.client
            },
            editLink() {
                return `/quotations/${this.model.id}/edit`
            }
        },
        methods: {
            fetchData() {
                this.$store.dispatch('fetchById', {
                    path: `quotations/${this.$route.params.id}`
                })
            }
        }
    }
</script>