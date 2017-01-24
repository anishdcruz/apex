<template>
    <span>
        <span v-if="id === 1" class="status status-grey">Draft</span>
        <span v-else-if="id === 2" class="status status-light_blue">Sent</span>
        <span v-else-if="id === 3" class="status status-green">Open</span>
        <span v-else-if="id === 4" class="status status-red">Closed</span>
        <span v-else-if="id === 5" class="status status-blue">Invoiced</span>
    </span>
</template>
<script type="text/javascript">
    export default {
        props: ['id']
    }
</script>