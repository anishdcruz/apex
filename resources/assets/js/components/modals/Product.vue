<template>
    <span class="modal-base">
        <button class="btn btn-secondary" @click="toggle">Search</button>
        <div class="modal" v-if="show">
            <div class="modal-content">
                <div class="modal-heading">
                    <p class="modal-title">Search Products</p>
                    <input type="text" class="form-control modal-search" placeholder="Search..">
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox"></th>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="x in 12">
                                <td><input type="checkbox"></td>
                                <td>12</td>
                                <td>Mr John Doe</td>
                                <td>Name of the title will be here</td>
                                <td>$243.00</td>
                                <td>12 May 2017</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer modal-footer_center">
                    <span>Showing 10 of 100</span>
                    <div class="modal-controls">
                        <button class="btn btn-primary">Add to Line</button>
                        <button class="btn" @click="toggle">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>
<script type="text/javascript">
    export default {
        data() {
            return {
                show: false
            }
        },
        methods: {
            toggle() {
                this.show = !this.show
            }
        }
    }
</script>