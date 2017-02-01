<template>
    <div class="view">
        <div class="panel">
            <div class="panel-heading">
                <p class="panel-title">
                    <span>Purchase Order</span>
                    <status :id="model.status_id" class="status-lg"></status>
                </p>
                <div class="panel-controls">
                    <div class="btn-group">
                        <button @click="$router.back()" class="btn">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                        <router-link :to="editLink" class="btn">
                            <i class="fa fa-pencil-square-o"></i>
                        </router-link>
                    </div>
                    <div class="btn-group">
                        <a target="_blank" :href="'/api/invoices/' + model.id + '/pdf'" class="btn">
                            <i class="fa fa-file-pdf-o"></i>
                        </a>
                        <a target="_blank" :href="'/api/invoices/' + model.id + '/pdf?opt=download'" class="btn">
                            <i class="fa fa-download"></i>
                        </a>
                        <router-link :to="editLink" class="btn">
                            <i class="fa fa-envelope-o"></i>
                        </router-link>
                        <dropdown title="More">
                            <dropdown-link :to="sentLink" v-if="model.status_id === 1">
                                Mark as Sent
                            </dropdown-link>
                            <dropdown-link :to="voidLink" v-if="model.status_id != 3">
                                Mark as Void
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
                            <p>
                                <strong>Title: </strong>
                                <span>{{model.title}}</span>
                            </p>
                            <strong>To:</strong><br>
                            <pre>{{vendor.person}},<br>{{vendor.company}},<br>{{vendor.billing_address}}</pre>
                        </div>
                        <div class="col-sm-3 col-sm-offset-1">
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
                                        <td>Reference:</td>
                                        <td>{{model.reference}}</td>
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
    import Dropdown from '../../components/Dropdown.vue'
    import DropdownLink from '../../components/DropdownLink.vue'
    import Status from '../../components/status/Invoice.vue'
    export default {
        name: 'PurchaseOrderShow',
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
            editLink() {
                return `/invoices/${this.model.id}/edit`
            },
            salesLink() {
                return `/invoices/${this.model.id}/sales-order`
            },
            invoiceLink() {
                return `/invoices/${this.model.id}/invoice`
            },
            sentLink() {
                return `/invoices/${this.model.id}/status/sent`
            },
            voidLink() {
                return `/invoices/${this.model.id}/status/void`
            },
            cloneLink() {
                return `/invoices/${this.model.id}/clone`
            }
        },
        methods: {
            fetchData() {
                this.$store.dispatch('fetchById', {
                    path: `purchase_orders/${this.$route.params.id}`
                })
            }
        }
    }
</script>