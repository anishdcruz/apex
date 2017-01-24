<template>
    <span class="modal-base">
        <button class="btn btn-secondary" @click="toggle">Search</button>
        <div class="modal" v-if="show">
            <div class="modal-content">
                <div class="modal-heading">
                    <p class="modal-title">Search Products</p>
                    <input type="text" class="form-control modal-search"
                        placeholder="Search.." v-model="query.q"
                        @keyup.enter="fetchData">
                </div>
                <div class="modal-body">
                    <table class="table table-link">
                        <thead>
                            <tr>
                                <th><input type="checkbox" disabled></th>
                                <th>Item Code</th>
                                <th>Description</th>
                                <th>Unit Price</th>
                                <th>Vendor Ref</th>
                                <th>Vendor Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in model.data" @click="toggleItem(item)">
                                <td>
                                    <input type="checkbox" v-model="item.check">
                                </td>
                                <td>{{item.item_code}}</td>
                                <td>{{item.description}}</td>
                                <td>
                                    {{item.unit_price}}
                                    <small>{{item.currency.code}}</small>
                                </td>
                                <td>{{item.vendor_ref}}</td>
                                <td>
                                    {{item.vendor_price}}
                                    <small>{{item.currency.code}}</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer modal-footer_center">
                    <div class="pagination">
                        <div class="pagination-controls">
                            <button class="btn" @click="prevPage" :disabled="!model.prev_page_url">&laquo; Prev</button>
                            <button class="btn" @click="nextPage" :disabled="!model.next_page_url">Next &raquo;</button>
                        </div>
                        <span class="pagination-status">
                            Showing {{model.from}} - {{model.to}} of {{model.total}}
                        </span>
                    </div>
                    <div class="modal-controls">
                        <button class="btn btn-primary" v-if="list.length" @click="add">
                            Add {{list.length}}
                        </button>
                        <button class="btn" @click="toggle">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import axios from 'axios'
    export default {
        created() {
            this.fetchData()
        },
        data() {
            return {
                show: false,
                model: {
                    data: []
                },
                list: [],
                query: {
                    page: 1,
                    q: '',
                }
            }
        },
        methods: {
            add() {
                // emit
                this.$emit('add', {
                    target: {
                        value: this.list
                    }
                })
                // un-check all
                this.model.data.forEach(function(item) {
                    item.check = false
                })
                // remove
                this.list = []
                this.toggle()
            },
            toggleItem(item) {
                item.check = true
                // if exists remove
                var found = this.list.find(function(x) {
                    return item.id === x.id
                })

                if(found) {
                    // TODO: uncheck item
                    var index = this.list.indexOf(found)

                    if (index > -1) {
                        this.list.splice(index, 1);
                    }
                } else {
                    this.list.push(item)
                }

            },
            toggle() {
                this.show = !this.show
            },
            nextPage(){
                if(this.model.next_page_url) {
                    this.query.page++;
                    this.fetchData()
                }
            },
            prevPage() {
                if(this.model.prev_page_url) {
                    this.query.page--;
                    this.fetchData()
                }
            },
            fetchData() {
                var vm = this
                axios.get('/api/products/search', {
                    params: this.query
                })
                    .then(function(response) {
                        Vue.set(vm.$data, 'model', response.data.model)
                    })
                    .catch(function(error) {

                    })
            }
        }
    }
</script>