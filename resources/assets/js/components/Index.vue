<template>
    <div class="panel">
        <div class="panel-heading">
            <p class="panel-title">Clients</p>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th v-for="item in thead">
                            <span v-text="item.title"></span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <slot v-for="item in model.data" :item="item"></slot>
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            <div class="pagination">
                <div class="pagination-controls">
                    <button class="btn">&laquo; Prev</button>
                    <button class="btn">Next &raquo;</button>
                </div>
                <span class="pagination-status">Showing 10 of 100</span>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    export default {
        props: ['thead'],
        computed: {
            model() {
                return this.$store.getters.model
            }
        }
    }
</script>