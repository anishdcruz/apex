<template>
    <span :class="['status', type.color]">
        {{type.title}}
    </span>
</template>
<script type="text/javascript">
    export default {
        props: ['id'],
        computed: {
            type() {
                const types = [
                    { id: 1, color: 'status-grey', title: 'Draft'},
                    { id: 2, color: 'status-light_blue', title: 'Sent'},
                    { id: 3, color: 'status-green', title: 'Accepted'},
                    { id: 4, color: 'status-red', title: 'Declined'},
                    { id: 5, color: 'status-blue', title: 'Invoiced'}
                ]
                var vm = this
                return types.find(function(item) {
                    return item.id === vm.id
                })
            }
        }
    }
</script>