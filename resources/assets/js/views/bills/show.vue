<template>
    <div class="view">
        <div class="panel">
            <div class="panel-heading">
                <p class="panel-title">
                    <span>Bill</span>
                    <status :id="model.status_id" class="status-lg"></status>
                </p>
                <div class="panel-controls">
                    <div class="btn-group">
                        <button @click="$router.back()" class="btn">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                    </div>
                    <div class="btn-group">
                        <a target="_blank" :href="'/api/bills/' + model.id + '/pdf'" class="btn">
                            <i class="fa fa-file-pdf-o"></i>
                        </a>
                        <a target="_blank" :href="'/api/bills/' + model.id + '/pdf?opt=download'" class="btn">
                            <i class="fa fa-download"></i>
                        </a>
                        <router-link :to="cloneLink" class="btn">
                            <i class="fa fa-envelope-o"></i>
                        </router-link>
                        <dropdown title="More">
                            <dropdown-link :to="sentLink" v-if="model.status_id === 1">
                                Mark as Sent
                            </dropdown-link>
                            <dropdown-link :to="cloneLink">
                                Clone
                            </dropdown-link>
                            <li>
                                <a href="#">Delete</a>
                            </li>
                        </dropdown>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="document">
                    <div class="row">
                        <div class="col-sm-8">
                            <strong>Bill From:</strong><br>
                            <pre>{{vendor.person}},<br>{{vendor.company}},<br>{{vendor.billing_address}}</pre>
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
                                        <td>Due Date:</td>
                                        <td>{{model.due_date | formatDate}}</td>
                                    </tr>
                                    <tr v-if="model.purchase_order_id">
                                        <td>Our Purchase Order:</td>
                                        <td>{{purchase.number}}</td>
                                    </tr>
                                    <tr>
                                        <td>Vendor Invoice No:</td>
                                        <td>{{model.vendor_invoice_no}}</td>
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
                                <td class="right">{{item.unit_price | formatMoney(currency)}}</td>
                                <td class="center">{{item.qty}}</td>
                                <td class="right">{{(item.qty * item.unit_price) | formatMoney(currency)}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">
                                    Payment Made
                                </td>
                                <td class="right">
                                    {{model.amount_paid | formatMoney(currency)}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">
                                    <strong>Grand Total</strong>
                                </td>
                                <td class="right">
                                    <strong>{{model.total | formatMoney(currency)}}</strong>
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
    import Dropdown from '../../components/Dropdown.vue'
    import DropdownLink from '../../components/DropdownLink.vue'
    import Status from '../../components/status/Bill.vue'
    export default {
        name: 'BillShow',
        components: {
            DropdownLink,
            Dropdown,
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
            vendor() {
                return this.$store.getters.vendor
            },
            purchase() {
                return this.$store.getters.purchase
            },
            sentLink() {
                return `/bills/${this.model.id}/status/sent`
            },
            voidLink() {
                return `/bills/${this.model.id}/status/void`
            },
            cloneLink() {
                return `/bills/${this.model.id}/clone`
            }
        },
        methods: {
            fetchData() {
                this.$store.dispatch('fetchById', {
                    path: `bills/${this.$route.params.id}`
                })
            }
        }
    }
</script>