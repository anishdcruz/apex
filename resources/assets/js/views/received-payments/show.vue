<template>
    <div class="view">
        <div class="panel">
            <div class="panel-heading">
                <p class="panel-title">
                    <span>Received Payment</span>
                </p>
                <div class="panel-controls">
                    <div class="btn-group">
                        <button @click="$router.back()" class="btn">Back</button>
                    </div>
                    <div class="btn-group">
                        <a target="_blank" :href="'/api/received_payments/' + model.id + '/pdf'" class="btn">
                            <i class="fa fa-file-pdf-o"></i>
                        </a>
                        <a target="_blank" :href="'/api/received_payments/' + model.id + '/pdf?opt=download'" class="btn">
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                    <button class="btn btn-danger">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="document">
                    <div class="row">
                        <div class="col-sm-8">
                            <strong>Paid By:</strong><br>
                            <pre><br>{{client.company}},<br>{{client.billing_address}}</pre>
                        </div>
                        <div class="col-sm-4">
                            <table class="table-summary">
                                <tbody>
                                    <tr>
                                        <td>Number:</td>
                                        <td>{{model.number}}</td>
                                    </tr>
                                    <tr>
                                        <td>Date:</td>
                                        <td>{{model.date | formatDate}}</td>
                                    </tr>
                                    <tr>
                                        <td>Payment Mode:</td>
                                        <td>{{model.payment_mode}}</td>
                                    </tr>
                                    <tr v-if="model.reference">
                                        <td>Reference:</td>
                                        <td>{{model.reference}}</td>
                                    </tr>
                                    <tr>
                                        <td>Amount Received:</td>
                                        <td>
                                            {{model.amount_received | formatMoney(currency)}}
                                        </td>
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
                                <th>Invoice No.</th>
                                <th>Invoice Date</th>
                                <th>Invoice Title</th>
                                <th class="right">Invoice Total</th>
                                <th class="right">Amount Applied</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in model.items">
                                <td>{{item.invoice.number}}</td>
                                <td>{{item.invoice.date | formatDate}}</td>
                                <td>{{item.invoice.title}}</td>
                                <td class="right">
                                    {{item.invoice.total | formatMoney(item.invoice.currency, true)}}
                                </td>
                                <td class="right">
                                    {{item.applied_amount | formatMoney(currency, true)}}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="right">
                                <td colspan="2"></td>
                                <td colspan="2">Amount Received</td>
                                <td>
                                    {{model.amount_received | formatMoney(currency, true)}}
                                </td>
                            </tr>
                            <tr class="right">
                                <td colspan="2"></td>
                                <td colspan="2">
                                    <strong>Amount Used</strong>
                                </td>
                                <td>
                                    <strong>{{model.amount_used | formatMoney(currency, true)}}</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Status from '../../components/status/Invoice.vue'
    export default {
        name: 'ReceivedPaymentShow',
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
                return `/received-payments/${this.model.id}/edit`
            }
        },
        methods: {
            fetchData() {
                this.$store.dispatch('fetchById', {
                    path: `received_payments/${this.$route.params.id}`
                })
            }
        }
    }
</script>