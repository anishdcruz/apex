<template>
    <div class="view">
        <div class="panel">
            <div class="panel-heading">
                <p class="panel-title">{{model.person}} / {{model.company}}</p>
                <div class="panel-controls">
                    <button @click="$router.back()" class="btn">Back</button>
                    <router-link :to="editLink" class="btn btn-secondary">Edit</router-link>
                    <button class="btn btn-danger">Delete</button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-3 profile">
                        <p class="profile-item">
                            <i class="fa fa-user-circle-o"></i>
                            <span>{{model.person}}</span>
                        </p>
                        <p class="profile-item">
                            <i class="fa fa-building-o"></i>
                            <span>{{model.company}}</span>
                        </p>
                        <p class="profile-item">
                            <i class="fa fa-envelope-o"></i>
                            <span>{{model.email}}</span>
                        </p>
                        <p class="profile-item">
                            <i class="fa fa-phone"></i>
                            <span>{{model.telephone}}</span>
                        </p>
                        <p class="profile-item">
                            <i class="fa fa-map-marker"></i>
                            <pre>{{model.billing_address}}</pre>
                        </p>
                        <p class="profile-item">
                            <i class="fa fa-map-marker"></i>
                            <pre>{{model.shipping_address}}</pre>
                        </p>
                        <p class="profile-item">
                            <i class="fa fa-money"></i>
                            <span>{{currency.name}}</span>
                        </p>
                        <p class="profile-item">
                            <i class="fa fa-clock-o"></i>
                            <span>{{model.created_at}}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    export default {
        name: 'ClientShow',
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
            editLink() {
                return `/clients/${this.model.id}/edit`
            }
        },
        methods: {
            fetchData() {
                this.$store.dispatch('fetchById', {
                    path: `clients/${this.$route.params.id}`
                })
            }
        }
    }
</script>