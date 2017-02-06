<template>
    <div class="view">
        <div class="panel">
            <div class="panel-heading">
                <p class="panel-title">Expense</p>
                <div class="panel-controls">
                    <button @click="$router.back()" class="btn">Back</button>
                    <button class="btn btn-danger">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="show-item">
                            <label>Vendor</label>
                            <p>{{vendor.person}} / {{vendor.company}}</p>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 show-item">
                                <label>Date</label>
                                <p>
                                    {{model.date | formatDate}}
                                </p>
                            </div>
                            <div class="col-sm-6 show-item">
                                <label>Amount</label>
                                <p>
                                    {{model.amount | formatMoney(currency, true)}}
                                </p>
                            </div>
                        </div>
                        <div class="show-item">
                            <label>Created At</label>
                            <p>{{model.created_at}}</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="show-item">
                            <label>Account</label>
                            <p>{{model.account}}</p>
                        </div>
                        <div class="show-item">
                            <label>Paid Through</label>
                            <p>{{model.paid_through}}</p>
                        </div>
                        <div class="show-item" v-if="model.payment_reference">
                            <label>Payment Ref</label>
                            <p>{{model.payment_reference}}</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="show-item" v-if="model.vendor_receipt">
                            <label>Vendor Receipt</label>
                            <p>{{model.vendor_receipt}}</p>
                        </div>
                        <div class="show-item">
                            <label>Internal Note</label>
                            <pre>{{model.internal_note}}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel" v-if="model.image">
            <div class="panel-heading">
                <p class="panel-title">Vendor Receipt</p>
            </div>
            <div class="panel-body">
                <img :src="'/images/' + model.image" class="image">
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    export default {
        name: 'ExpenseShow',
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
            vendor() {
                return this.$store.getters.vendor
            }
        },
        methods: {
            fetchData() {
                this.$store.dispatch('fetchById', {
                    path: `expenses/${this.$route.params.id}`
                })
            }
        }
    }
</script>