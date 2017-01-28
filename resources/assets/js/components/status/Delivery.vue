<template>
    <span>
        <span v-if="id === 1" class="status status-grey">Draft</span>
        <span v-else-if="id === 2" class="status status-light_blue">Picked</span>
        <span v-else-if="id === 3" class="status status-green">Delivered</span>
    </span>
</template>
<script type="text/javascript">
    export default {
        props: ['id']
    }
</script>