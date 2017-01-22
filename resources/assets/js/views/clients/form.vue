<template>
    <div class="view">
        <div class="panel">
            <div class="panel-heading">
                <p class="panel-title">{{title}}</p>
            </div>
            <div class="panel-body">
                <div class="row form">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Person</label>
                            <input type="text" class="form-control">
                            <small class="e-text"></small>
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <input type="text" class="form-control">
                            <small class="e-text"></small>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="text" class="form-control">
                            <small class="e-text"></small>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Telephone</label>
                            <input type="text" class="form-control">
                            <small class="e-text"></small>
                        </div>
                        <div class="form-group">
                            <label>Billing Address</label>
                            <textarea class="form-control"></textarea>
                            <small class="e-text"></small>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Currency</label>
                            <typeahead :items="[]" v-model="name"></typeahead>
                            <small class="e-text"></small>
                        </div>
                        <div class="form-group">
                            <label>Shipping Address</label>
                            <textarea class="form-control"></textarea>
                            <small class="e-text"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="panel-controls">
                    <button class="btn">Cancel</button>
                    <button class="btn btn-primary" v-text="button"></button>
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
                redirect: '/clients',
                title: 'Create Client',
                initalize: 'clients/create',
                store: 'clients',
                method: 'post',
                button: 'Create'
            }
        },
        created() {
            if(this.$route.meta.mode === 'edit') {
                this.title = 'Edit Client'
                this.initalize = `clients/${this.$route.params.id}/edit`
                this.store = `clients/${this.$route.params.id}`
                this.method = 'put'
                this.button = 'Save'
            }
        },
        components: {
            Typeahead
        }
    }
</script>