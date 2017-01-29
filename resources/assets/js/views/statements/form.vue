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
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>From Date</label>
                            <input type="date" class="form-control" v-model="form.from_date">
                            <small class="e-text" v-if="errors.from_date">{{errors.from_date[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label>To Date</label>
                            <input type="date" class="form-control" v-model="form.to_date">
                            <small class="e-text" v-if="errors.to_date">{{errors.to_date[0]}}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel">
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
    import Typeahead from '../../components/Typeahead.vue'
    export default {
        data() {
            return {
                redirect: '/statements',
                title: 'Generate Statement',
                initalize: 'statements/create',
                store: 'statements',
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
            Typeahead
        }
    }
</script>