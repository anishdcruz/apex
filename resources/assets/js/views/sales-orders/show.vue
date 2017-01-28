<template>
    <div class="view">
        <div class="panel">
            <div class="panel-heading">
                <p class="panel-title">
                    <span>Sales Order</span>
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
                        <a target="_blank" :href="'/api/quotations/' + model.id + '/pdf'" class="btn">
                            <i class="fa fa-file-pdf-o"></i>
                        </a>
                        <a target="_blank" :href="'/api/quotations/' + model.id + '/pdf?opt=download'" class="btn">
                            <i class="fa fa-download"></i>
                        </a>
                        <router-link :to="editLink" class="btn">
                            <i class="fa fa-envelope-o"></i>
                        </router-link>
                        <dropdown title="More">
                            <dropdown-link :to="invoiceLink" v-if="model.status_id === 3">
                                Convert to Invoice
                            </dropdown-link>
                            <dropdown-link :to="deLink" v-if="model.status_id === 3">
                                Create Delivery Note
                            </dropdown-link>
                            <dropdown-link :to="sentLink" v-if="model.status_id === 1">
                                Mark as Sent
                            </dropdown-link>
                            <dropdown-link :to="openLink" v-if="model.status_id === 2 || model.status_id === 4">
                                Mark as Open
                            </dropdown-link>
                            <dropdown-link :to="closeLink" v-if="model.status_id === 2 || model.status_id === 3">
                                Mark as Closed
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
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong>Bill To:</strong><br>
                                    <pre>{{client.person}},<br>{{client.company}},<br>{{client.billing_address}}</pre>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Ship To:</strong><br>
                                    <pre>{{client.person}},<br>{{client.company}},<br>{{client.shipping_address}}</pre>
                                </div>
                            </div>
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
                                    <tr v-if="model.customer_po">
                                        <td>Customer PO:</td>
                                        <td>{{model.customer_po}}</td>
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
        <div class="panel">
            <div class="panel-heading">
                <p class="panel-title">Delivery Notes</p>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Date</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in model.deliveries">
                            <td>{{item.number}}</td>
                            <td>{{item.date}}</td>
                            <td>{{item.created_at}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Dropdown from '../../components/Dropdown.vue'
    import DropdownLink from '../../components/DropdownLink.vue'
    import Status from '../../components/status/SalesOrder.vue'
    export default {
        name: 'SalesOrderShow',
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
            client() {
                return this.$store.getters.client
            },
            editLink() {
                return `/sales-orders/${this.model.id}/edit`
            },
            salesLink() {
                return `/sales-orders/${this.model.id}/sales-order`
            },
            invoiceLink() {
                return `/sales-orders/${this.model.id}/invoice`
            },
            sentLink() {
                return `/sales-orders/${this.model.id}/status/sent`
            },
            openLink() {
                return `/sales-orders/${this.model.id}/status/open`
            },
            closeLink() {
                return `/sales-orders/${this.model.id}/status/close`
            },
            cloneLink() {
                return `/sales-orders/${this.model.id}/clone`
            },
            deLink() {
                return `/sales-orders/${this.model.id}/delivery`
            }
        },
        methods: {
            fetchData() {
                this.$store.dispatch('fetchById', {
                    path: `sales_orders/${this.$route.params.id}`
                })
            }
        }
    }
</script>