<template>
    <div class="view">
        <div class="panel">
            <div class="panel-heading">
                <p class="panel-title">Document Settings</p>
            </div>
            <div class="panel-body">
                <div class="form">
                    <div class="from-group">
                        <label>Upload Page Header</label>
                        <input type="file" @change="uploadHeader">
                        <small class="e-text" v-if="errors.header">
                            {{errors.header[0]}}
                        </small>
                    </div>
                    <div class="from-group">
                        <label>Upload Page Footer</label>
                        <input type="file" @change="uploadFooter">
                        <small class="e-text" v-if="errors.footer">
                            {{errors.footer[0]}}
                        </small>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="panel-controls">
                    <button class="btn" @click="$router.back()">Cancel</button>
                    <button class="btn btn-primary" @click="submit">Upload</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import axios from 'axios'
    import Vue from 'vue'
    export default {
        data() {
            return {
                header: null,
                footer: null,
                errors: {}
            }
        },
        methods: {
            uploadFooter(e) {
                var input = e.target
                if (input.files && input.files[0]) {
                    this.footer = input.files[0]
                }
            },
            uploadHeader(e) {
                var input = e.target
                if (input.files && input.files[0]) {
                    this.header = input.files[0]
                }
            },
            submit() {
                var fd = new FormData()
                if(this.header) {
                    fd.append('header', this.header)
                }
                if(this.footer) {
                    fd.append('footer', this.footer)
                }
                var vm = this
                axios.post('/api/settings/document', fd)
                    .then(function(response) {

                    })
                    .catch(function(error) {
                        Vue.set(vm.$data, 'errors', error.response.data)
                    })
            }
        }
    }
</script>