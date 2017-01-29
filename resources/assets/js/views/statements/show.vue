<template>
    <div class="view">
        <div class="panel">
            <div class="panel-heading">
                <p class="panel-title">
                    <span>Statement of Account</span>
                </p>
                <div class="panel-controls">
                    <div class="btn-group">
                        <button @click="$router.back()" class="btn">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                    </div>
                    <div class="btn-group">
                        <a target="_blank" :href="'/api/statements/' + model.id + '/pdf'" class="btn">
                            <i class="fa fa-file-pdf-o"></i>
                        </a>
                        <a target="_blank" :href="'/api/statements/' + model.id + '/pdf?opt=download'" class="btn">
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="document">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong>To:</strong><br>
                                    <pre>{{client.person}},<br>{{client.company}},<br>{{client.billing_address}}</pre>
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
                                        <td>From Date:</td>
                                        <td>{{model.from_date}}</td>
                                    </tr>
                                    <tr>
                                        <td>To Date:</td>
                                        <td>{{model.to_date}}</td>
                                    </tr>
                                    <tr>
                                        <td>Opening Balance:</td>
                                        <td>{{model.opening_balance}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Number</th>
                                <th>Debits</th>
                                <th>Credits</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in model.items">
                                <td>{{item.date}}</td>
                                <td>{{item.type}}</td>
                                <td>{{item.number}}</td>
                                <td>{{item.debits}}</td>
                                <td>{{item.credits}}</td>
                                <td>{{item.balance}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">
                                    <strong>Balance Due</strong>
                                </td>
                                <td>
                                    <strong>{{model.total}}</strong>
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
    export default {
        name: 'StatementShow',
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
            client() {
                return this.$store.getters.client
            },
        },
        methods: {
            fetchData() {
                this.$store.dispatch('fetchById', {
                    path: `statements/${this.$route.params.id}`
                })
            }
        }
    }
</script>